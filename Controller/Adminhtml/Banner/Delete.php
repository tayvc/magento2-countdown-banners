<?php

namespace SFS\CountdownBanners\Controller\Adminhtml\Banner;

use SFS\CountdownBanners\Model\Banner;
use Magento\Backend\App\Action;

class Delete extends Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('banner_id');

        if (!($banner = $this->_objectManager->create(Banner::class)->load($id))) {
            $this->messageManager->addError(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        try {
            $banner->delete();
            $this->messageManager->addSuccess(__('Your countdown banner has been deleted !'));
        } catch (Exception $e) {
            $this->messageManager->addError(__('Error while trying to delete banner: '));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}
