<?php

namespace Pol\Printers\Controller\Adminhtml\Printers;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Backend\Model\View\Result\Redirect;
use Pol\Printers\Domain\PrintersRepository;
use Pol\Printers\Model\Printers;
use Pol\Printers\Model\PrintersFactory;

/**
 * Save CMS block action.
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BlockFactory|null $blockFactory
     * @param BlockRepositoryInterface|null $blockRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        private PrintersFactory $printersFactory,
        private readonly PrintersRepository $printersRepository
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue('general');
        if ($data) {
            /** @var Printers $model */
            $model = $this->printersFactory->create();
            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->printersRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This Printer no longer exists.'));
                    return $resultRedirect->setPath('*/*/listing');
                }
            }

            $model->setData($data);

            try {
                $this->printersRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Printer.'));
                $this->dataPersistor->clear('pol_printer');
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            $this->dataPersistor->set('pol_printer', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/listing');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/listing');
        }
        return $resultRedirect;
    }

    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Pol_Printers::printers_save');
    }
}
