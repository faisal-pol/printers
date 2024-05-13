<?php

namespace Pol\Printers\Controller\Adminhtml\Printers;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        private ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Pol_Printers::printers_add_new');
    }

    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
