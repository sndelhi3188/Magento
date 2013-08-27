 <?php
 class Mage_Catalog_Block_Product_Bestseller extends Mage_Catalog_Block_Product_Abstract{
    public function __construct(){
        parent::__construct();
        if ($this->getParam('website')) {
            $storeIds = Mage::app()->getWebsite($this->getParam('website'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else if ($this->getParam('group')) {
            $storeIds = Mage::app()->getGroup($this->getParam('group'))->getStoreIds();
            $storeId = array_pop($storeIds);
        } else {
            $storeId = (int)$this->getParam('store');
        }
        //$storeId = Mage::app()->getStore()->getId();
        $products = Mage::getResourceModel('sales/report_bestsellers_collection')
			->setModel('catalog/product')
            ->addOrderedQty()
            //->addAttributeToSelect('*')
            ->addAttributeToSelect(array('name', 'price', 'small_image'))
            ->setStoreId($storeId)
            ->addStoreFilter($storeId)
            ->setOrder('ordered_qty', 'desc'); // most best sellers on top
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
 
        $products->setPageSize(3)->setCurPage(1);
        $this->setProductCollection($products);
    }
}
