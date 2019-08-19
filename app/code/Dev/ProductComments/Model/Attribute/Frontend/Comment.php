<?php
namespace Dev\ProductComments\Model\Attribute\Frontend;

use Magento\Framework\DataObject;
use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;

class Comment extends AbstractFrontend
{
    /**
     * @param DataObject $object
     * @return mixed|string
     */
    public function getValue(DataObject $object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        return "<b>$value</b>";
    }
}
