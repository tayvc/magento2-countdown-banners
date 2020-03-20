<?php

namespace SFS\CountdownBanners\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use SFS\CountdownBanners\Model\BannerFactory;

/**
 * Save countdown banner action.
 *
 */
class Save extends Action
{
    /**
     * @var BannerFactory
     */
    private $bannerFactory;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param BannerFactory $bannerFactory
     */
    public function __construct(Context $context, Registry $coreRegistry, PageFactory $resultPageFactory, BannerFactory $bannerFactory)
    {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context, $coreRegistry, $resultPageFactory, $bannerFactory);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            try {
                $id = $data['banner_id'];
                $bannerModel = $this->bannerFactory->create();

                if ($id) {
                    $bannerModel->load($id);
                }

                $data = array_filter($data, function ($value) {
                    return $value !== '';
                });
                $bannerModel->setData($data);
                $bannerModel->save();

                $this->messageManager->addSuccess(__('Successfully saved the countdown banner.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                return $resultRedirect->setPath('*/*/');

            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $bannerModel->getId()]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
