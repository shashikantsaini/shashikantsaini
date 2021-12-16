<?php
namespace Bluethink\CustomApi\Controller\Adminhtml\Action;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Response\Http\FileFactory;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\Order\Address ;
use Magento\Sales\Model\Order;
 
class Pdf extends \Magento\Backend\App\Action
{
    protected $fileFactory;
 
    public function __construct(
        Context $context,
        Shipment $ship,
        \Magento\Framework\Registry $coreRegistry,
        Address $orderAddress,
        Order $order,
        FileFactory $fileFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->ship = $ship;
        $this->orderAddress = $orderAddress;
        $this->order = $order;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $pdf = new \Zend_Pdf();
        $pdf->pages[] = $pdf->newPage(\Zend_Pdf_Page::SIZE_LETTER_LANDSCAPE);
        $page = $pdf->pages[0]; // this will get reference to the first page.
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0,0,0));
        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_TIMES);
        $style->setFont($font,13);
        $page->setStyle($style);
        $width = $page->getWidth();
        $hight = $page->getHeight();
        $x = 30;
        $pageTopalign = 612; 
        $this->y = 612 - 100; 
        
        $style->setFont($font,14);
        $page->setStyle($style);
        $page->drawRectangle(30, $this->y - 60, $page->getWidth()-30, $this->y +70, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawLine($page->getWidth()-394, $this->y - 60, $page->getWidth()-398, $this->y +70);
        $style->setFont($font,20);
        $page->setStyle($style);
        $page->drawText(__("Ship To :"), $x + 5, $this->y+50, 'UTF-8');
        $style->setFont($font,13);
        $page->setStyle($style);
        $incrementId = $this->getRequest()->getParam('order_id');
        $order = $this->order->loadByIncrementId($incrementId);        
        $orderAdd = $order->getShippingAddress();
        // echo "<pre>";
        // print_r($orderAdd->getData());
        // die();
        $page->drawText(__("Name : %1", $orderAdd->getFirstName()." ".$orderAdd->getMiddleName()."".$orderAdd->getLastName()), $x + 5, $this->y+33, 'UTF-8');
        $page->drawText(__("Address : %1",$orderAdd->getStreet()), $x + 5, $this->y+16, 'UTF-8');
        $page->drawText(__("%1",$orderAdd->getCity()), $x + 57, $this->y-1, 'UTF-8');
        $page->drawText(__("%1",$orderAdd->getRegion()), $x + 57, $this->y-18, 'UTF-8');
        $page->drawText(__("%1",$orderAdd->getPostcode()), $x + 57, $this->y-33, 'UTF-8');
        $page->drawText(__("%1",$orderAdd->getTelephone()), $x + 57, $this->y-50, 'UTF-8');
 
        // $style->setFont($font,11);
        // $page->setStyle($style);
        
        // $page->drawText(__("PRODUCT NAME"), $x + 60, $this->y-10, 'UTF-8');
        // $page->drawText(__("PRODUCT PRICE"), $x + 200, $this->y-10, 'UTF-8');
        // $page->drawText(__("QTY"), $x + 310, $this->y-10, 'UTF-8');
        // $page->drawText(__("SUB TOTAL"), $x + 440, $this->y-10, 'UTF-8');
 
        // $style->setFont($font,10);
        // $page->setStyle($style);
        // $add = 9;
        
        // $page->drawText("$12.00", $x + 210, $this->y-30, 'UTF-8');
        // $page->drawText(10, $x + 330, $this->y-30, 'UTF-8');
        // $page->drawText("$120.00", $x + 470, $this->y-30, 'UTF-8');
        // $pro = "TEST product";
        // $page->drawText($pro, $x + 65, $this->y-30, 'UTF-8');
        
        // $page->drawRectangle(30, $this->y -62, $page->getWidth()-30, $this->y + 10, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        // $page->drawRectangle(30, $this->y -62, $page->getWidth()-30, $this->y - 100, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        // $style->setFont($font,15);
        // $page->setStyle($style);
        // $page->drawText(__("Total : %1", "$50.00"), $x + 435, $this->y-85, 'UTF-8');
        
        // $style->setFont($font,10);
        // $page->setStyle($style);
        // $page->drawText(__("Test Footer example"), ($page->getWidth()/2)-50, $this->y-200);
 
        $fileName = 'test1'.\date('m-d-Y_hia').'.pdf';
 
        $this->fileFactory->create(
           $fileName,
           $pdf->render(),
           \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR, // this pdf will be saved in var directory with the name test.pdf
           'application/pdf'
        );
    }
}