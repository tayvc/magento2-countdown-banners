<?php

namespace SFS\CountdownBanners\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Banner extends AbstractDb
{
    protected $_idFieldName = 'banner_id';

    protected function _construct()
    {
        $this->_init('countdown_banners','banner_id');
    }
}
