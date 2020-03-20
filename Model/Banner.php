<?php

namespace SFS\CountdownBanners\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'countdown_banners';

    protected function _construct()
    {
        $this->_init('SFS\CountdownBanners\Model\ResourceModel\Banner');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    /**
     * Get status of banner model based on its active state
     * and display dates compared to the current date/time.
     * @return bool
     */
    public function isActive()
    {
        $status = false;
        $displayStart = $this->getDisplayStart();
        $displayEnd = $this->getDisplayEnd();
        $currentDate = date('Y-m-d H:i:s');

        //Check that banner is enabled and display dates are currently active
        if ($this->getIsActive() && $displayStart <= $currentDate && $displayEnd >= $currentDate) {
            $status = true;
        }

        return $status;
    }


    /**
     * Get status of banner model's countdown timer on its
     * active state and dates compared to the current date/time.
     * @return bool
     */
    public function isTimerActive()
    {
        $status = false;
        $timerStart = $this->getTimerStart();
        $timerEnd = $this->getTimerEnd();
        $currentDate = date('Y-m-d H:i:s');

        //Check that banner has timer enabled and timer dates are currently active
        if ($this->getTimerEnabled() && $timerStart <= $currentDate && $timerEnd >= $currentDate) {
            $status = true;
        }

        return $status;
    }
}
