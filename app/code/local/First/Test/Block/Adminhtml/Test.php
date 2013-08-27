<?php


class First_Test_Block_Adminhtml_Test extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_test";
	$this->_blockGroup = "test";
	$this->_headerText = Mage::helper("test")->__("Test Manager");
	$this->_addButtonLabel = Mage::helper("test")->__("Add New Item");
	parent::__construct();
	
	}

}