<?php


class Bestylish_Testview_Block_Adminhtml_Testview extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_testview";
	$this->_blockGroup = "testview";
	$this->_headerText = Mage::helper("testview")->__("Testview Manager");
	$this->_addButtonLabel = Mage::helper("testview")->__("Add New Item");
	parent::__construct();
	
	}

}