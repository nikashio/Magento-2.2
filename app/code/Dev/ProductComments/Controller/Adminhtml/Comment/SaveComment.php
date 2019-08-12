<?php

namespace Dev\ProductComments\Controller\Adminhtml\Comment;

use Dev\ProductComments\Model\Comment;
use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;

class SaveComment extends Action
{
    /**
     * @var Comment
     */
    private $commentModel;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        Comment $commentModel
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->commentModel = $commentModel;
    }
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('comment_id');
            $model = $this->commentModel->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Comment no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the comment.'));
                $this->dataPersistor->clear('product_comments');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/add', ['comment_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the comment.'));
            }
            $this->dataPersistor->set('product_comments', $data);
            return $resultRedirect->setPath('*/*/add', ['comment_id' => $this->getRequest()->getParam('comment_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
