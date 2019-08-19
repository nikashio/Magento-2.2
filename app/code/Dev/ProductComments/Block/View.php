<?php

namespace Dev\ProductComments\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Dev\ProductComments\Model\CommentRepository;

class View extends Template
{
    /**
     * @var Registry
     */
    private $registry;
    protected $commentFactory;
    private $productRepository;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * View constructor.
     * @param CommentRepository $commentRepository
     * @param Template\Context $context
     * @param Registry $registry
     * @param CollectionFactory $commentFactory
     * @param ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        CommentRepository $commentRepository,
        Template\Context $context,
        Registry $registry,
        CollectionFactory $commentFactory,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->commentFactory = $commentFactory;
        $this->productRepository = $productRepository;
        $this->commentRepository = $commentRepository;
    }
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getCommentCollection($productId)
    {
        return $this->commentRepository->getList($productId);
    }

    public function getProductName($productId)
    {
        return $this->productRepository->getById($productId)->getName();
    }
}

