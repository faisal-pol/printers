<?php

namespace Pol\Printers\Block\Adminhtml\Printers\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\BlockRepositoryInterface;
use Pol\Printers\Domain\PrintersRepository;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    public function __construct(
        private Context $context,
        private readonly PrintersRepository $printersRepository
    ) {
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getPrinterId(): int|null
    {
        $printer = $this->printersRepository->findById($this->context->getRequest()->getParam('entity_id', 0));
        return $printer?->getId();
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
