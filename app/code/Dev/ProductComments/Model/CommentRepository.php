<?php

namespace Dev\ProductComments\Model;

use Dev\ProductComments\Api\Data\CommentInterface;
use Dev\ProductComments\Api\CommentRepositoryInterface;
use Dev\ProductComments\Model\ResourceModel\Comment\Collection;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var CommentCollectionFactory
     */
    private $commentCollectionFactory;
    private $CollectionFactory;

    /**
     * CommentRepository constructor.
     * @param CommentFactory $commentFactory
     * @param CommentCollectionFactory $commentCollectionFactory
     */
    public function __construct(
        CollectionFactory $commentFactory,
        CommentCollectionFactory $commentCollectionFactory
    )
    {
        $this->commentFactory = $commentFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
    }

    /**
     * @param int $id
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $comment = $this->commentFactory->create();
        $comment->getResource()->load($comment, $id);
        return $comment;
    }

    /**
     * @param CommentInterface $comment
     * @return CommentInterface
     */
    public function save(CommentInterface $comment)
    {
        $comment->getResource()->save($comment);
        return $comment;
    }

    /**
     * @param CommentInterface $comment
     * @return void
     */
    public function delete(CommentInterface $comment)
    {
           $comment->getResource()->delete($comment);
    }

    /**
     * @param $productId
     * @return \Dev\ProductComments\Api\Data\CommentSearchResultInterface|\Magento\Framework\DataObject[]
     */
    public function getList($productId)
    {
        $comment = $this->commentFactory->create();
        $collection = $comment
            ->addFieldToFilter('product_id', $productId)
            ->addFieldToFilter('status', 'approved')
            ->getItems();
        return $collection;
    }
}

