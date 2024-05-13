<?php

namespace Pol\Printers\Ui\Component\Grid\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Webtexpert\Taylorapi\Model\Config\Source\ProductGroupList;

class ProductGroupOptions implements OptionSourceInterface
{
    public function __construct(private readonly ProductGroupList $groupList)
    {

    }
    public function getOptionArray(): array
    {
        return $this->groupList->toOptionArray();
    }

    /**
     * Get Grid row status labels array with empty value for option element.
     */
    public function getAllOptions(): array
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get Grid row type array for option element.
     */
    public function getOptions(): array
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $value['value'], 'label' => $value['label']];
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
