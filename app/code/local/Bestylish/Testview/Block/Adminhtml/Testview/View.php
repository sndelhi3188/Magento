<?php
	
class Bestylish_Testview_Block_Adminhtml_Testview_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "test_view_id";
				$this->_blockGroup = "testview";
				$this->_controller = "adminhtml_testview";
				/*$this->_updateButton("save", "label", Mage::helper("testview")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("testview")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("testview")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}*/

		public function getHeaderText()
		{
				if( Mage::registry("testview_data") && Mage::registry("testview_data")->getId() ){

				    return Mage::helper("testview")->__("View Item '%s'", $this->htmlEscape(Mage::registry("testview_data")->getId()));

				} 
				else{

				     return Mage::helper("testview")->__("Add Item");

				}
		}
}
