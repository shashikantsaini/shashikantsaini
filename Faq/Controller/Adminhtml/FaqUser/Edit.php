<?php
namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Bluethink\Faq\Model\FaqUserFactory;

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
     * @var FaqUserFactory
     */    
    private $faqUserFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param FaqUserFactory $faqUserFactory
     */    
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        FaqUserFactory $faqUserFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqUserFactory = $faqUserFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $faqUserId = (int) $this->getRequest()->getParam('user_faq_id');
        $faqUserData = $this->faqUserFactory->create();
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($faqUserId) {
           $faqUserData = $faqUserData->load($faqUserId);
           $faqUserAuth = $faqUserData->getAuthorizeStatus();
           $faqUserDec = $faqUserData->getDeclineStatus();
           if ($faqUserAuth || $faqUserDec) {
               $this->messageManager->addError(__('User FAQ already Checked.'));
               $this->_redirect('adminfaq/faquser/index');
               return;
           }
       }

       $this->coreRegistry->register('faquser_data', $faqUserData);
       $resultPage = $this->resultPageFactory->create();
       $resultPage->getConfig()->getTitle()->prepend('Check User FAQ');
       return $resultPage;
    }
}