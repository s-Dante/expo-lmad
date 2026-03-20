<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Patrocinador;
use Illuminate\Database\Eloquent\Collection;

/**
 * Contrato para operaciones CRUD de Patrocinadores/Empresas.
 */
interface PatrocinadorRepositoryInterface
{
    /**
     * Obtiene todos los patrocinadores con sus representantes.
     *
     * @return Collection<int, Patrocinador>
     */
    public function getAll(): Collection;

    /**
     * Obtiene patrocinadores activos para dropdowns.
     *
     * @return Collection<int, Patrocinador>
     */
    public function getAllForDropdown(): Collection;

    /**
     * Crea un nuevo patrocinador.
     *
     * @param array $data
     * @return Patrocinador
     */
    public function create(array $data): Patrocinador;

    /**
     * Actualiza un patrocinador existente.
     *
     * @param Patrocinador $patrocinador
     * @param array $data
     * @return Patrocinador
     */
    public function update(Patrocinador $patrocinador, array $data): Patrocinador;

    /**
     * Elimina (soft-delete) un patrocinador.
     *
     * @param Patrocinador $patrocinador
     * @return void
     */
    public function delete(Patrocinador $patrocinador): void;
}
