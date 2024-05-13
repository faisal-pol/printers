<?php

namespace Pol\Printers\Controller\Adminhtml\Printers;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Pol\Printers\Domain\PrintersRepository;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    public function __construct(
        Action\Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly PrintersRepository $printersRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        if ($id = $this->getRequest()->getParam('id')) {
            $printer = $this->printersRepository->getById($id);
        } else {
            $printer = $this->printersRepository->create();
        }

        /** @var ResultInterface $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Pol_Printers::printers');

        if ($printer->getId()) {
            $resultPage->getConfig()->getTitle()->prepend('Pol Printer: '. $printer->getName());
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Printer'));
        }
        $resultPage->addBreadcrumb(
            $id ? __('Edit Printer') : __('Edit Printer'),
            $id ? __('Edit Printer') : __('Edit Printer')
        );

        return $resultPage;
    }
}
