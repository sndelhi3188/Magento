 <?php     
    require_once('/var/www/magento/app/Mage.php');
    Mage::app('admin');
    Mage::getSingleton("core/session", array("name" => "adminhtml"));
    Mage::register('isSecureArea',true);
    $collection = Mage::getResourceModel('sales/order_collection')
    ->addAttributeToSelect('*')
    ->setPageSize(1)
    ->addFieldToFilter('status', 'canceled')->load();
     
    foreach ($collection as $col) {
//    Mage::log($col->getIncrementId() . ' order deleted ');
	    try {
		    $col->delete();
		    Mage::log($col->getIncrementId() ." Order deleted");
	    } catch (Exception $e) {
		    throw $e;
	    }
    }
