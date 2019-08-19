<?php

namespace Dev\ProductComments\Controller\Adminhtml\Comment;

use Exception;
use Dev\ProductComments\Model\Comment;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Dev\ProductComments\Model\CommentRepository;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action
{
    private $commentModel;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(
        Context $context,
        Comment $commentModel,
        CommentRepository $commentRepository
    ) {
        parent::__construct($context);
        $this->commentModel = $commentModel;
        $this->commentRepository = $commentRepository;
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $id = $params['id'];
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            if (!($contact = $this->commentRepository->getById($id))) {
                $this->messageManager->addErrorMessage(__('Unable to proceed. Please, try again.'));
                return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            }
        } catch (NoSuchEntityException $e) {
            $e->getMessage();
        }
        try {
            $this->delete();
            $this->messageManager->addSuccessMessage(__('Your contact has been deleted !'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete comment: '));
            return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }
        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
