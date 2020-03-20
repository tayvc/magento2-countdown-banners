<?php

namespace SFS\CountdownBanners\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Source model for banner with enable and disable variants.
 *
 */
class Status implements ArrayInterface
{
    /**
     * Value which equals Enabled for Status dropdown.
     */
    const ENABLE_VALUE = 1;

    /**
     * Value which equals Disabled for Status dropdown.
     */
    const DISABLE_VALUE = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::ENABLE_VALUE, 'label' => __('Enabled')],
            ['value' => self::DISABLE_VALUE, 'label' => __('Disabled')],
        ];
    }
}
