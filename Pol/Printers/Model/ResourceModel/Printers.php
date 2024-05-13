<?php

namespace Pol\Printers\Model\ResourceModel;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Pol\Printers\Api\Data\Printer;

class Printers extends AbstractDb
{
    public function __construct(
        private readonly EntityManager $entityManager,
        Context $context,
        private MetadataPool $metadataPool,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init('pol_printers', 'entity_id');
    }

    public function save(AbstractModel $object): self
    {
        $this->entityManager->save($object);
        return $this;
    }

    /*public function load(AbstractModel $object, $value, $field = null)
    {
        dd($object);
        $printerId = $this->getPrinterId($object, $value, $field);
        if ($printerId) {
            $this->entityManager->load($object, $printerId);
        }
        return $this;
    }

    private function getPrinterId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(Printer::class);
        if (!is_numeric($value) && $field === null) {
            $field = 'entity_id';
        } elseif (!$field) {
            $field = $entityMetadata->getIdentifierField();
        }
        $entityId = $value;
        if ($field != $entityMetadata->getIdentifierField()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);
            $result = $this->getConnection()->fetchCol($select);
            $entityId = count($result) ? $result[0] : false;
        }
        return $entityId;
    }*/
}
