<?php
class Bestylish_Testview_TestviewController extends Mage_Core_Controller_Front_Action{
		public function IndexAction() {
				  
				  $this->loadLayout();   
				  $this->getLayout()->getBlock("head")->setTitle($this->__("Testview"));
						$breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
				  $breadcrumbs->addCrumb("home", array(
							"label" => $this->__("Home Page"),
							"title" => $this->__("Home Page"),
							"link"  => Mage::getBaseUrl()
					   ));

				  $breadcrumbs->addCrumb("viewtest", array(
							"label" => $this->__("Testview"),
							"title" => $this->__("Testview")
					   ));

				  $this->renderLayout(); 
				  
		}
}