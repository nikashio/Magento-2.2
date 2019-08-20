<?php
namespace Dev\ProductComments\Block\Widget;

use Magento\Catalog\Helper\Image;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\Helper\Data as CurrencySymbol;

class Comments extends Template implements BlockInterface
{

    protected $_template = 'widget/comments.phtml';

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;
    /**
     * Posts constructor.
     *
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $criteriaBuilder
     */
    private $imageHelper;

    /**
     * @var CurrencySymbol
     */
    private $currencySymbol;

    /**
     * Posts constructor.
     *
     * @param Template\Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $criteriaBuilder
     * @param Image $imageHelper
     * @param CurrencySymbol $currencySymbol
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        Image $imageHelper,
        CurrencySymbol $currencySymbol,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productRepository = $productRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->imageHelper = $imageHelper;
        $this->currencySymbol = $currencySymbol;
    }

    public function getProductCollection($maxProducts)
    {
        $criteria = $this->criteriaBuilder
            ->addFilter('ProductComment', 'yes')
            ->create()
            ->setPageSize($maxProducts);
        return $this->productRepository
            ->getList($criteria)
            ->getItems();
    }

    public function getItemImage($product)
    {
        return $this->imageHelper->init($product, 'product_base_image')->getUrl();
    }

    public function getCurrencySymbol($price)
    {
        return $this->currencySymbol->currency($price);
    }

    public function getCommentCollection($productId)
    {
        $comment = $this->commentFactory->create();
        $collection = $comment->getCollection()
            ->addFilter('product_id', $productId)
            ->addFilter('status', 'approved');
        return $collection;
    }
}
