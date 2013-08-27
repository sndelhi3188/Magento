<?php
class Inchoo_Vendor_Model_Activpayment
{
    public function getActivPaymentMethods()
    {
       $payments = Mage::getSingleton('payment/config')->getActiveMethods();
       //$methods = array(array('value'=>'', 'label'=>Mage::helper('adminhtml')->__('--Please Select--')));
       foreach ($payments as $paymentCode=>$paymentModel) {
            //$paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
            $methods[]= $paymentCode;
        }
        return $methods;
    }
}
