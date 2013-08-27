 <?php     
    require_once('/var/www/magento/app/Mage.php');
    Mage::app();
	$allActivePaymentMethods = Mage::getModel('payment/config')->getActiveMethods();
	print_r($allActivePaymentMethods);

