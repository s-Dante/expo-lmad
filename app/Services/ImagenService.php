<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Convierte cualquier imagen subida a formato WebP antes de guardarla.
 *
 * Ventajas:
 *   - WebP pesa ~30% menos que JPEG y ~25% menos que PNG con calidad equivalente.
 *   - Un solo formato simplifica la gestión del storage.
 *   - Compatible con todos los navegadores modernos.
 *
 * Usa la extensión GD (incluida por defecto en PHP 8+ y Laravel Cloud).
 * Funciona con local y S3 porque escribe los bytes vía Storage::put().
 *
 * Uso:
 *   $ruta = ImagenService::guardarWebp($request->file('logo'), 'patrocinadores/logos');
 *   // devuelve algo como: "patrocinadores/logos/550e8400-e29b-41d4-a716.webp"
 */
class ImagenService
{
    /** Calidad WebP por defecto (0-100). 82 es un buen equilibrio tamaño/nitidez. */
    private const CALIDAD_DEFAULT = 82;

    /**
     * Convierte la imagen a WebP y la almacena en el disco 'public'.
     *
     * @param  UploadedFile $archivo   Archivo subido por el usuario
     * @param  string       $carpeta   Carpeta destino dentro del disco public (ej. 'proyectos/posters')
     * @param  int          $calidad   Calidad WebP (0-100), default 82
     * @return string                  Ruta relativa almacenada (para guardar en BD)
     */
    public static function guardarWebp(
        UploadedFile $archivo,
        string $carpeta,
        int $calidad = self::CALIDAD_DEFAULT
    ): string {
        $nombre       = Str::uuid()->toString() . '.webp';
        $rutaRelativa = trim($carpeta, '/') . '/' . $nombre;

        // Intentar conversión con GD
        $gdImage = self::crearImagenGD($archivo);

        if ($gdImage === null) {
            // GD no soporta el formato o la extensión GD no está instalada:
            // guardar el archivo original sin convertir como fallback seguro.
            $extension    = $archivo->getClientOriginalExtension() ?: 'jpg';
            $rutaFallback = trim($carpeta, '/') . '/' . Str::uuid()->toString() . '.' . $extension;
            Storage::disk('public')->put($rutaFallback, file_get_contents($archivo->getRealPath()));
            return $rutaFallback;
        }

        // Capturar los bytes WebP en memoria (null como destino = buffer)
        ob_start();
        imagewebp($gdImage, null, $calidad);
        $bytesWebp = ob_get_clean();
        imagedestroy($gdImage);

        // Guardar via Storage (funciona con 'local' y con 'S3')
        Storage::disk('public')->put($rutaRelativa, $bytesWebp);

        return $rutaRelativa;
    }

    /**
     * Crea un recurso GD a partir del archivo subido.
     * Preserva el canal alfa en imágenes PNG para que la transparencia
     * se mantenga correctamente en el WebP resultante.
     *
     * @return \GdImage|null  null si el formato no es soportado
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

        // Para PNG: convertir a truecolor y preservar transparencia
        if (str_contains($mime, 'png')) {
            $ancho  = imagesx($gd);
            $alto   = imagesy($gd);
            $canvas = imagecreatetruecolor($ancho, $alto);

            // Fondo transparente
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparente = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $ancho, $alto, $transparente);

            // Copiar imagen original preservando alfa
            imagealphablending($canvas, true);
            imagecopy($canvas, $gd, 0, 0, 0, 0, $ancho, $alto);
            imagedestroy($gd);

            return $canvas;
        }

        return $gd;
    }
}
