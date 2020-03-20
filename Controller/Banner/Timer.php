<?php

namespace SFS\CountdownBanners\Controller\Banner;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use SFS\CountdownBanners\Model\BannerFactory;

/***
 * Class Timer
 *
 * @package SFS\CountdownBanners\Controller\Banner
 */
class Timer extends Action
{
    protected $_bannerFactory;
    protected $jsonHelper;
    protected $jsonFactory;
    protected $timezone;

    /**
     * Timer constructor
     *
     * @param Context $context
     * @param BannerFactory $bannerFactory
     * @param JsonHelper $jsonHelper
     * @param JsonFactory $jsonFactory
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        JsonHelper $jsonHelper,
        JsonFactory $jsonFactory,
        TimezoneInterface $timezone
    ) {
        $this->_bannerFactory = $bannerFactory;
        $this->jsonHelper = $jsonHelper;
        $this->jsonFactory = $jsonFactory;
        $this->timezone = $timezone;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $bannerId = $this->getRequest()->getParam('id');

        if ($bannerId) {
            $bannerModel = $this->_bannerFactory->create();
            $bannerModel->load($bannerId);

            return $resultJson->setData([
                'success' => true,
                'active' => $bannerModel->isActive(),
                'timerEnabled' => $bannerModel->isTimerActive(),
                'timerStart' => $bannerModel->getTimerStart(),
                'timerEnd' => $bannerModel->getTimerEnd(),
                'systemTime' => $this->timezone->date(),
            ]);
        }

        return $resultJson->setData(['success' => false]);
    }
}
