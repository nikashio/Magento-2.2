<?php
namespace Dev\ProductComments\Controller\Adminhtml\Comment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory;
use Dev\ProductComments\Model\CommentRepository;

class Disapprove extends Action
{
    protected $filter;

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

            $item->setStatus('not approved');
            $this->commentRepository->save($item);
        }
        $this->messageManager->addSuccessMessage(__('Elements have been disapproved.'));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}

