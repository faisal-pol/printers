<?php

namespace Pol\Printers\Model\ResourceModel\Printers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Pol\Printers\Model\Printers;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            Printers::class,
            \Pol\Printers\Model\ResourceModel\Printers::class
        );
    }
}
