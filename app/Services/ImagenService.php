<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Convierte cualquier imagen subida a formato WebP antes de guardarla.
 *
 * Usa el disco 'public' de Laravel:
 *   - Desarrollo local: storage/app/public  (servido vía /storage con artisan storage:link)
 *   - Laravel Cloud:    R2 (LARAVEL_CLOUD_DISK_CONFIG reemplaza 'public' automáticamente)
 *
 * Uso:
 *   $ruta = ImagenService::guardarWebp($file, 'proyectos/posters', nombre: 'Mi Proyecto');
 *   // → "proyectos/posters/mi-proyecto.webp"
 *
 *   $url = ImagenService::url($ruta); // URL pública (local o S3)
 */
class ImagenService
{
    /** Calidad WebP por defecto (0-100). 82 es buen equilibrio tamaño/nitidez. */
    private const CALIDAD_DEFAULT = 82;

    /**
     * Disco de almacenamiento.
     * - Local: usa storage/app/public (accesible vía /storage)
     * - Laravel Cloud: LARAVEL_CLOUD_DISK_CONFIG reemplaza 'public' con R2 automáticamente.
     *   No necesita credenciales separadas — Laravel Cloud las inyecta solo.
     */
    private const DISCO = 'public';

    /**
     * Convierte la imagen a WebP y la almacena en el disco de medios configurado.
     *
     * @param  UploadedFile $archivo    Archivo subido por el usuario
     * @param  string       $carpeta    Carpeta destino (ej. 'proyectos/posters')
     * @param  int          $calidad    Calidad WebP (0-100), default 82
     * @param  string|null  $nombreBase Nombre base para el archivo (ej. "Mi Proyecto").
     *                                  Si se omite se usa un UUID.
     * @return string                   Ruta relativa almacenada (para guardar en BD)
     */
    public static function guardarWebp(
        UploadedFile $archivo,
        string $carpeta,
        int $calidad = self::CALIDAD_DEFAULT,
        ?string $nombreBase = null
    ): string {
        // Generar nombre de archivo
        if ($nombreBase) {
            $slug   = Str::slug($nombreBase);
            $nombre = ($slug ?: Str::random(10)) . '.webp';
        } else {
            $nombre = Str::uuid()->toString() . '.webp';
        }

        $rutaRelativa = trim($carpeta, '/') . '/' . $nombre;

        // Intentar conversión con GD
        $gdImage = self::crearImagenGD($archivo);

        if ($gdImage === null) {
            // Fallback: guardar original sin convertir
            $extension      = $archivo->getClientOriginalExtension() ?: 'jpg';
            $nombreFallback = $nombreBase
                ? (Str::slug($nombreBase) ?: Str::random(10)) . '.' . $extension
                : Str::uuid()->toString() . '.' . $extension;
            $rutaFallback = trim($carpeta, '/') . '/' . $nombreFallback;
            Storage::disk(self::DISCO)->put($rutaFallback, file_get_contents($archivo->getRealPath()));
            return $rutaFallback;
        }

        // Capturar bytes WebP en memoria
        ob_start();
        imagewebp($gdImage, null, $calidad);
        $bytesWebp = ob_get_clean();
        imagedestroy($gdImage);

        // Guardar (funciona con local y S3)
        Storage::disk(self::DISCO)->put($rutaRelativa, $bytesWebp);

        return $rutaRelativa;
    }

    /**
     * Devuelve la URL pública de un archivo guardado por este servicio.
     * Funciona correctamente tanto con disco local como con S3.
     *
     * @param  string|null $ruta  Ruta relativa devuelta por guardarWebp()
     * @return string|null        URL pública, o null si la ruta es nula/vacía
     */
    public static function url(?string $ruta): ?string
    {
        if (!$ruta) return null;
        return Storage::disk(self::DISCO)->url($ruta);
    }

    /**
     * Crea un recurso GD a partir del archivo subido.
     * Preserva el canal alfa en imágenes PNG.
     *
     * @return \GdImage|null  null si el formato no es soportado o GD no está instalado
     */
    private static function crearImagenGD(UploadedFile $archivo): ?\GdImage
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $ruta = $archivo->getRealPath();
        $mime = $archivo->getMimeType() ?? '';

        $gd = match (true) {
            str_contains($mime, 'jpeg'), str_contains($mime, 'jpg') => @imagecreatefromjpeg($ruta),
            str_contains($mime, 'png')  => @imagecreatefrompng($ruta),
            str_contains($mime, 'gif')  => @imagecreatefromgif($ruta),
            str_contains($mime, 'webp') => @imagecreatefromwebp($ruta),
            str_contains($mime, 'bmp')  => @imagecreatefrombmp($ruta),
            default                     => null,
        };

        if (!$gd instanceof \GdImage) {
            return null;
        }

        // Para PNG: preservar transparencia
        if (str_contains($mime, 'png')) {
            $ancho  = imagesx($gd);
            $alto   = imagesy($gd);
            $canvas = imagecreatetruecolor($ancho, $alto);

            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparente = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $ancho, $alto, $transparente);

            imagealphablending($canvas, true);
            imagecopy($canvas, $gd, 0, 0, 0, 0, $ancho, $alto);
            imagedestroy($gd);

            return $canvas;
        }

        return $gd;
    }
}
