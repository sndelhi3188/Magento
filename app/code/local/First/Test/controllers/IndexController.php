<?php
class First_Test_IndexController extends Mage_Core_Controller_Front_Action{
    public function IndexAction() {
      
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("test"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("test", array(
                "label" => $this->__("test"),
                "title" => $this->__("test")
		   ));

      $this->renderLayout(); 
	  
    }
    public function testAction(){
		echo "hello Test";
	}
}
