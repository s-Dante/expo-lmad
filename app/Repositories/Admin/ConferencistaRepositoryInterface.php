<?php

declare(strict_types=1);

namespace App\Repositories\Admin;

use App\Models\Conferencista;
use Illuminate\Database\Eloquent\Collection;

/**
 * Contrato para operaciones CRUD de Conferencistas.
 */
interface ConferencistaRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllForDropdown(): Collection;
    public function create(array $data): Conferencista;
    public function update(Conferencista $conferencista, array $data): Conferencista;
    public function delete(Conferencista $conferencista): void;
}
