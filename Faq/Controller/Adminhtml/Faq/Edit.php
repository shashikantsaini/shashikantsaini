<?php
namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Bluethink\Faq\Model\FaqFactory;

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
     * @var FaqFactory
     */    
    private $faqFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param FaqFactory $faqFactory
     */    
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqFactory = $faqFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $faqId = (int) $this->getRequest()->getParam('faq_id');
        $faqData = $this->faqFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($faqId) {
           $faqData = $faqData->load($faqId);
           $faqTitle = $faqData->getTitle();
           if (!$faqData->getFaqId()) {
               $this->messageManager->addError(__('FAQ Group no longer exist.'));
               $this->_redirect('adminfaq/faqgroup/index');
               return;
           }
       }

       $this->coreRegistry->register('faq_data', $faqData);
       $resultPage = $this->resultPageFactory->create();
       $title = $faqId ? __('Edit FAQ ').$faqTitle : __('Add FAQ');
       $resultPage->getConfig()->getTitle()->prepend($title);
       return $resultPage;
    }
}