<?php
namespace Dev\ProductComments\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory;
use Dev\ProductComments\Model\CommentRepository;

class MassDelete extends Action
{
    private $filter;

    protected $collectionFactory;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CommentRepository $commentRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
        $this->commentRepository = $commentRepository;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
        } catch (LocalizedException $e) {
             $e->getMessage();
        }
        foreach ($collection as $item) {
            $this->commentRepository->delete($item);
        }
        $this->messageManager->addSuccessMessage(__('Comments have been deleted.'));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
