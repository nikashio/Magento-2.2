<?php

namespace Dev\ProductComments\Model\Comment;

use Dev\ProductComments\Model\Comment;
use Magento\Backend\Model\Auth\Session;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use Dev\ProductComments\Model\ResourceModel\Comment\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private $loadedData;
    /**
     * @var DataPersistorInterface
     */

    protected $collection;
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Comment
     */

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param Session $session
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        Session $session,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->session = $session;
    }

    public function getData()
    {
        $items = $this->collection->getItems();
        foreach ($items as $comment) {
            $this->loadedData[$comment->getId()] = $comment->getData();
        }

        if (count($items) === 0) {
            $name = $this->session->getUser()->getUserName();
            $email = $this->session->getUser()->getEmail();
            $comment = $this->collection->getNewEmptyItem();
            $comment->setData('name', $name);
            $comment->setData('email', $email);
            $comment->setData('do_we_hide_it', true);
            $this->loadedData[$comment->getId()] = $comment->getData();
        }
        return $this->loadedData;
    }
}
