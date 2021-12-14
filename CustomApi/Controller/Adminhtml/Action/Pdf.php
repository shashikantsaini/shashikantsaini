<?php
namespace Bluethink\CustomApi\Controller\Adminhtml\Action;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Response\Http\FileFactory;
use Magento\Sales\Model\Order\Shipment;
 
class Pdf extends \Magento\Backend\App\Action
{
    protected $fileFactory;
 
    public function __construct(
        Context $context,
        Shipment $ship, 
        FileFactory $fileFactory
    ) {
        $this->fileFactory = $fileFactory;
        $this->ship = $ship;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $pdf = new \Zend_Pdf();
        $pdf->pages[] = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);
        $page = $pdf->pages[0]; // this will get reference to the first page.
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0,0,0));
        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_TIMES);
        $style->setFont($font,13);
        $page->setStyle($style);
        $width = $page->getWidth();
        $hight = $page->getHeight();
        $x = 30;
        $pageTopalign = 850; 
        $this->y = 850 - 100; 
        
        $style->setFont($font,14);
        $page->setStyle($style);
        $page->drawRectangle(30, $this->y + 10, $page->getWidth()-30, $this->y +70, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        $style->setFont($font,13);
        $page->setStyle($style);
        $page->drawText(__("Cutomer Details"), $x + 5, $this->y+50, 'UTF-8');
        $style->setFont($font,11);
        $page->setStyle($style);
        $page->drawText(__("Name : %1", "Test Meetanshi"), $x + 5, $this->y+33, 'UTF-8');
        $page->drawText(__("Email : %1","test@meetanshi.com"), $x + 5, $this->y+16, 'UTF-8');
 
        $style->setFont($font,11);
        $page->setStyle($style);
        
        $page->drawText(__("PRODUCT NAME"), $x + 60, $this->y-10, 'UTF-8');
        $page->drawText(__("PRODUCT PRICE"), $x + 200, $this->y-10, 'UTF-8');
        $page->drawText(__("QTY"), $x + 310, $this->y-10, 'UTF-8');
        $page->drawText(__("SUB TOTAL"), $x + 440, $this->y-10, 'UTF-8');
 
        $style->setFont($font,10);
        $page->setStyle($style);
        $add = 9;
        
        $page->drawText("$12.00", $x + 210, $this->y-30, 'UTF-8');
        $page->drawText(10, $x + 330, $this->y-30, 'UTF-8');
        $page->drawText("$120.00", $x + 470, $this->y-30, 'UTF-8');
        $pro = "TEST product";
        $page->drawText($pro, $x + 65, $this->y-30, 'UTF-8');
        
        $page->drawRectangle(30, $this->y -62, $page->getWidth()-30, $this->y + 10, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $page->drawRectangle(30, $this->y -62, $page->getWidth()-30, $this->y - 100, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        
        $style->setFont($font,15);
        $page->setStyle($style);
        $page->drawText(__("Total : %1", "$50.00"), $x + 435, $this->y-85, 'UTF-8');
        
        $style->setFont($font,10);
        $page->setStyle($style);
        $page->drawText(__("Test Footer example"), ($page->getWidth()/2)-50, $this->y-200);
 
        $fileName = 'test.pdf';
 
        $this->fileFactory->create(
           $fileName,
           $pdf->render(),
           \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR, // this pdf will be saved in var directory with the name test.pdf
           'application/pdf'
        );
    }
}