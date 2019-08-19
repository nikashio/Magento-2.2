<?php
namespace Dev\ProductComments\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface CommentInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */

    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);

    /**
     * @return string
     */
    public function getStatus();


    /**
     * @param $status
     */
    public function setStatus($status);

}

