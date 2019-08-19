<?php

namespace Dev\ProductComments\Api;

use Dev\ProductComments\Api\Data\CommentInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CommentRepositoryInterface
{
    /**
     * @param int $id
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param CommentInterface $comment
     * @return \Dev\ProductComments\Api\Data\CommentInterface
     */
    public function save(CommentInterface $comment);

    /**
     * @param CommentInterface $comment
     * @return \Dev\ProductComments\Api\Data\CommentInterface
     */
    public function delete(CommentInterface $comment);

    /**
     * @param $productId
     * @return \Dev\ProductComments\Api\Data\CommentSearchResultInterface
     */
    public function getList($productId);

}
