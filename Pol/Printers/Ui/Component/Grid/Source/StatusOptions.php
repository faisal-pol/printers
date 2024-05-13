<?php

namespace Pol\Printers\Ui\Component\Grid\Source;

use Magento\Framework\Data\OptionSourceInterface;

class StatusOptions implements OptionSourceInterface
{
    public function getOptionArray(): array
    {
        return [
            1 => __('Yes'),
            0 => __('No')
        ];
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
            $res[] = ['value' => $index, 'label' => $value];
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
