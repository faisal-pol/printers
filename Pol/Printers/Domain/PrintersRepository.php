<?php

namespace Pol\Printers\Domain;

use Pol\Printers\Api\Data\Printer;

interface PrintersRepository
{
    public function getById(int $id): Printer;
    public function findById(int $id): ?Printer;
    public function save(Printer $printer): Printer;
    public function delete(Printer $printer): bool;
    public function deleteById(int $id): bool;
    public function create(): Printer;
}
