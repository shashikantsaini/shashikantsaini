<?php
namespace Bluethink\Quote\Controller\Adminhtml\Quote;
 
use Magento\SalesRule\Model\Rule;

class Coupon extends \Magento\Backend\App\Action
{
    /**
     * @var Rule
     */
    protected $rule;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Checkout\Model\Cart $cart,
        Rule $rule

    ) {
        parent::__construct($context);
        $this->cart = $cart;
        $this->shoppingCartPriceRule = $rule;
    }

    public function execute()
    {
        $quoteId= $this->getRequest()->getParam('quote_id');       
        $coupon = $this->createRule();
        $quote = $this->cart->getQuote()->load($quoteId)->setCouponCode($coupon)->collectTotals()->save();
    }
    /**
     * Create Rule
     *
     * @return void
     */
    public function createRule()
    {
        $coupon = [] ;
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; //random string to generate the code
        $ranCode = substr(str_shuffle($str_result), 0, 8); 
        $ranStr = substr(str_shuffle($str_result), 0, 5); 
        $coupon['name'] = 'TEST-'.$ranStr.''; //Generate a rule name
        $coupon['desc'] = 'Discount on First Shopping';
        $coupon['start'] = date('Y-m-d'); //Coupon use start date
        $coupon['end'] = ''; //coupon use end date
        $coupon['max_redemptions'] = 1; //Uses per Customer
        $coupon['discount_type'] ='cart_fixed'; //for discount type
        $coupon['discount_amount'] = 20; //discount amount/percentage
        $coupon['flag_is_free_shipping'] = 'no';
        $coupon['redemptions'] = 1;
        $coupon['code'] = $ranCode; //generate a random coupon code

        $this->shoppingCartPriceRule->setName($coupon['name'])
        ->setDescription($coupon['desc'])
        ->setFromDate($coupon['start'])
        ->setToDate($coupon['end'])
        ->setUsesPerCustomer($coupon['max_redemptions'])
        ->setCustomerGroupIds(array('1','2','3')) //select customer group
        ->setIsActive(1)
        ->setSimpleAction($coupon['discount_type'])
        ->setDiscountAmount($coupon['discount_amount'])
        ->setDiscountQty(1)
        ->setApplyToShipping($coupon['flag_is_free_shipping'])
        ->setTimesUsed($coupon['redemptions'])
        ->setWebsiteIds(array('1'))
        ->setCouponType(2)
        ->setCouponCode($coupon['code'])
        ->setUsesPerCoupon(1);
        $this->shoppingCartPriceRule->save();
        $couponCode =$this->shoppingCartPriceRule->getCouponCode();  
        return $couponCode;
    }
}