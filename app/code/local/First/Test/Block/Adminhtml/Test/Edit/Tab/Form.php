<?php
class First_Test_Block_Adminhtml_Test_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("test_form", array("legend"=>Mage::helper("test")->__("Item information")));

				
						$fieldset->addField("test_id", "text", array(
						"label" => Mage::helper("test")->__("id"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "test_id",
						));
					
						$fieldset->addField("name", "text", array(
						"label" => Mage::helper("test")->__("name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "name",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getTestData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getTestData());
					Mage::getSingleton("adminhtml/session")->setTestData(null);
				} 
				elseif(Mage::registry("test_data")) {
				    $form->setValues(Mage::registry("test_data")->getData());
				}
				return parent::_prepareForm();
		}
}
