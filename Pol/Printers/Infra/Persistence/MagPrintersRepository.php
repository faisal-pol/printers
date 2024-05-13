<?php

namespace Pol\Printers\Infra\Persistence;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Pol\Printers\Api\Data\Printer;
use Pol\Printers\Domain\PrintersRepository;
use Pol\Printers\Model\PrintersFactory;
use Pol\Printers\Model\ResourceModel\Printers as ResourceModel;

class MagPrintersRepository implements PrintersRepository
{
    public function __construct(
        private PrintersFactory $printersFactory,
        private readonly ResourceModel $resourceModel
    )
    {
    }

    public function getById(int $id): Printer
    {
        $printer = $this->printersFactory->create();
        $this->resourceModel->load($printer, $id);
        if (!$printer->getId()) {
            throw new NoSuchEntityException(__('The Printer with the ID"%1" doesn\'t exist.', $id));
        }
        return $printer;
    }

    public function findById(int $id): ?Printer
    {
        $printer = $this->printersFactory->create();
        $this->resourceModel->load($printer, $id);
        if (!$printer->getId()) {
            return null;
        }
        return $printer;
    }

    public function save(Printer $printer): Printer
    {
        try {
            $this->resourceModel->save($printer);
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $printer;
    }

    public function delete(Printer $printer): bool
    {
        try {
            $this->resourceModel->delete($printer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }

    public function create(): Printer
    {
        return $this->printersFactory->create();
    }
}
