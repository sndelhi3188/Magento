 <?php     
    require_once('/var/www/magento/app/Mage.php');
    Mage::app('admin');
    Mage::getSingleton("core/session", array("name" => "adminhtml"));
    Mage::register('isSecureArea',true);
    $collection = Mage::getResourceModel('sales/order_collection')
    ->addAttributeToSelect('*')
    ->setPageSize(1)
    ->addFieldToFilter('status', 'pending')
    ->addFieldToFilter('method','ccsave')
    ->load();
     
    foreach ($collection as $col) {
//    Mage::log($col->getIncrementId() . ' order deleted ');
	    try {
		    $col->setState(Mage_Sales_Model_Order::STATE_PROCESSING,true)->save();
		    Mage::log($col->getIncrementId() ." Order invoiced");
	    } catch (Exception $e) {
	    throw $e;
	    }
    }
