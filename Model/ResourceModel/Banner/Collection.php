<?php

namespace SFS\CountdownBanners\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    protected function _construct()
    {
        $this->_init('SFS\CountdownBanners\Model\Banner','SFS\CountdownBanners\Model\ResourceModel\Banner');
    }
}
