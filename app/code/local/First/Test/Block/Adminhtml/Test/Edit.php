<?php
	
class First_Test_Block_Adminhtml_Test_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "test_id";
				$this->_blockGroup = "test";
				$this->_controller = "adminhtml_test";
				$this->_updateButton("save", "label", Mage::helper("test")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("test")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("test")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("test_data") && Mage::registry("test_data")->getId() ){

				    return Mage::helper("test")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("test_data")->getId()));

				} 
				else{

				     return Mage::helper("test")->__("Add Item");

				}
		}
}