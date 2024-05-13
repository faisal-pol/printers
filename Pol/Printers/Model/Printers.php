<?php

namespace Pol\Printers\Model;

use Magento\Framework\Model\AbstractModel;
use Pol\Printers\Api\Data\Printer;

class Printers extends AbstractModel implements Printer
{
    protected function _construct()
    {
        $this->_init(\Pol\Printers\Model\ResourceModel\Printers::class);
    }

    public function getId(): int
    {
        return \intval($this->getData('entity_id'));
    }

    public function getName(): string
    {
        return $this->getData('name');
    }

    public function getCode(): string
    {
        return $this->getData('code');
    }

    public function isActive(): bool
    {
        return (true === boolval($this->getData('is_active')));
    }

    public function getProductGroup(): int
    {
        return \intval($this->getData('product_group'));
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return new \DateTimeImmutable($this->getData('created_at'));
    }

    public function setId($id): Printer
    {
        return $this->setData('entity_id', $id);
    }

    public function setCode(string $code): Printer
    {
        return $this->setData('code', $code);
    }

    public function setName(string $name): Printer
    {
        return $this->setData('name', $name);
    }

    public function setIsActive(bool $isActive): Printer
    {
        return $this->setData('is_active', $isActive);
    }

    public function setProductGroup(int $groupId): Printer
    {
        return $this->setData('product_group', $groupId);
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): Printer
    {
        return $this->setData('created_at', $createdAt->format('Y-m-d H:i:s'));
    }
}
