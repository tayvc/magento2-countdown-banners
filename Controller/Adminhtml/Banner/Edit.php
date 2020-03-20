<?php

namespace SFS\CountdownBanners\Controller\Adminhtml\Banner;

use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use SFS\CountdownBanners\Model\Banner;

/**
 * Edit countdown banner action.
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_CatalogRule::promo');
        return $resultPage;
    }

    /**
     * Edit countdown banner
     *
     * @return Page|Redirect
     */
    public function execute()
    {
        // Get banner ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        $model = $this->_objectManager->create(Banner::class);

        // Check that banner model exists
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('countdown_banner', $model);

        // Build edit form
        /** @var Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Countdown Banners'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('New Banner'));

        return $resultPage;
    }
}
