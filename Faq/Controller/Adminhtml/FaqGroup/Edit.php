<?php
namespace Bluethink\Faq\Controller\Adminhtml\FaqGroup;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Bluethink\Faq\Model\FaqGroupFactory;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */    
    private $coreRegistry;

    /**
     * @var FaqGroupFactory
     */     
    private $faqGroupFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param FaqGroupFactory $faqGroupFactory
     */     
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        FaqGroupFactory $faqGroupFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqGroupFactory = $faqGroupFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $faqGroupId = (int) $this->getRequest()->getParam('faqgroup_id');
        $faqGroupData = $this->faqGroupFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($faqGroupId) {
           $faqGroupData = $faqGroupData->load($faqGroupId);
           $faqGroupTitle = $faqGroupData->getTitle();
           if (!$faqGroupData->getFaqgroupId()) {
               $this->messageManager->addError(__('FAQ Group no longer exist.'));
               $this->_redirect('adminfaq/faqgroup/index');
               return;
           }
       }

       $this->coreRegistry->register('faqgroup_data', $faqGroupData);
       $resultPage = $this->resultPageFactory->create();
       $title = $faqGroupId ? __('Edit FAQ Group ').$faqGroupTitle : __('Add FAQ Group');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }
}