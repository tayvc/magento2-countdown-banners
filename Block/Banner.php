<?php

namespace SFS\CountdownBanners\Block;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use SFS\CountdownBanners\Model\BannerFactory;

/**
 * Countdown banner content block
 */
class Banner extends Template
{
    /**
     * Banner factory
     *
     * @var BannerFactory
     */
    protected $_bannerFactory;

    /**
     * Banner constructor.
     * @param Context $context
     * @param BannerFactory $bannerFactory
     * @param array $data
     */
    public function __construct(Context $context, BannerFactory $bannerFactory, array $data = [])
    {
        $this->_bannerFactory = $bannerFactory;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @param $bannerId
     * @return \SFS\CountdownBanners\Model\Banner
     */
    public function getBanner($bannerId)
    {
        $bannerModel = $this->_bannerFactory->create();
        return $bannerModel->load($bannerId);
    }

    /**
     * @param $banner
     * @return mixed|string|string[]
     */
    public function getBannerText($banner)
    {
        $text = $banner->getText();
        
        //Check that banner text contains a timer token
        $token = "{{timer}}";
        //Get position to only replace the first token instance
        $position = strpos($text, $token);
        if ($position !== false) {
            // Replace the banner's timer token with a countdown timer class
            $countdown = "<span id='banner-{$banner->getId()}' class='countdown-timer'
                            data-mage-init='{\"SFS_CountdownBanners/js/banner\":{\"timerEnd\":\"{$banner->getTimerEnd()} UTC\"}}'>
                            <span class='countdown-days digit'>00</span> 
                            <span class='countdown-hours digit'>00</span><span class='separator'>:</span><span class='countdown-minutes digit'>00</span><span class='separator'>:</span><span class='countdown-seconds digit'>00</span>                            
                            </span>";

            return substr_replace($text, $countdown, $position, strlen($token));
        }

        return $text;
    }

    /**
     * @param $banner
     * @return string
     */
    public function getBannerIcon($banner)
    {
        $icon = '';
        //Check if banner has an icon set
        if ($banner->getIcon()) {
            //Check if banner has an icon color
            if ($banner->getIconColor()) {
                //Set icon color inline style
                $icon = '<i class="fas fa-' . $banner->getIcon() . '" style="color: ' . $banner->getIconColor() . '"></i>';
            } else {
                $icon = '<i class="fas fa-' . $banner->getIcon() . '"></i>';
            }
        }
        return $icon;
    }

    /**
    * This function will be used to get the banner css file.
    * @param string $asset
    * @return string
    */
    public function getAssetUrl($asset)
    {
        $objectManager = ObjectManager::getInstance();
        $assetRepository = $objectManager->get('Magento\Framework\View\Asset\Repository');
        return $assetRepository->createAsset($asset)->getUrl();
    }

    /**
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('countdown_banners/banner/timer');
    }
}
