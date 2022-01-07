<?php

namespace Bluethink\Faq\Controller\Index;

use Magento\Framework\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class AddUserFaq extends \Magento\Framework\App\Action\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var PageFactory
     */
    protected $resultJsonFactory;

    /**
     * @var FaqUserFactory
     */ 
    var $faqUserFactory; 

    /**
     * AddUserFaq constructor.
     *
     * @param Context $context
     * @param FaqUserFactory $faqUserFactory
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Context $context,
        FaqUserFactory $faqUserFactory,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory
    )
    {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->faqUserFactory = $faqUserFactory;
        return parent::__construct($context);
    }


    public function execute()
    {
        $postdata = $this->getRequest()->getPostValue();
        if (!$postdata['title']) {
            $result = $this->resultJsonFactory->create();
            $result->setData(['status'=>202,'message'=>'Please ask a question']);
            return $result;
        }        

        try {
            $model = $this->faqUserFactory->create();
            
            $model->setData($postdata);

            $model->save();

            $result = $this->resultJsonFactory->create();
            $result->setData(['status'=>200,'message'=>'Your question is received. We will try to get answer as soon as possible']);
            return $result;
            
        } catch (\Exception $e) {
            $result = $this->resultJsonFactory->create();
            $result->setData(['status'=>201,'message'=>'Question not recived having some issue']);
            return $result;
        }
    } 
}