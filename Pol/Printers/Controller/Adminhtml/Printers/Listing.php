<?php

namespace Pol\Printers\Controller\Adminhtml\Printers;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Listing extends Action implements HttpGetActionInterface
{
    public function __construct(
        Context $context,
        private PageFactory $pageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Pol_Printers::printers_list');
        $resultPage->getConfig()->getTitle()->prepend(__('POL Printers'));
        return $resultPage;
    }
}
