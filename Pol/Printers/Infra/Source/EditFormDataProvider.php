<?php

namespace Pol\Printers\Infra\Source;

use Pol\Printers\Model\Printers;
use Pol\Printers\Model\ResourceModel\Printers\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Pol\Printers\Model\ResourceModel\Printers\Collection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class EditFormDataProvider extends AbstractDataProvider
{
    protected array $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        private CollectionFactory $collectionFactory,
        private DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $this->collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var Printers $printer */
        foreach ($items as $printer) {
            $this->loadedData[$printer->getId()] = $printer->getData();
        }
        $data = $this->dataPersistor->get('pol_printer');
        if (!empty($data)) {
            $printer = $this->collection->getNewEmptyItem();
            $printer->setData($data);
            $this->loadedData[$printer->getId()] = $printer->getData();
            $this->dataPersistor->clear('pol_printer');
        }

        return $this->loadedData;
    }
}
