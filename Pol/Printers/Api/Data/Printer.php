<?php

namespace Pol\Printers\Api\Data;

interface Printer
{
    public function getId(): int;
    public function getName(): string;
    public function getCode(): string;
    public function isActive(): bool;
    public function getProductGroup(): int;
    public function getCreatedAt(): \DateTimeInterface;
    public function setId($id): self;
    public function setName(string $name): self;
    public function setCode(string $code): self;
    public function setIsActive(bool $isActive): self;
    public function setProductGroup(int $groupId): self;
    public function setCreatedAt(\DateTimeInterface $createdAt): self;
}
