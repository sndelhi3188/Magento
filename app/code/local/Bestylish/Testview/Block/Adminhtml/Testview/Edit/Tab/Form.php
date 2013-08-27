<?php
class Bestylish_Testview_Block_Adminhtml_Testview_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("testview_form", array("legend"=>Mage::helper("testview")->__("Item information")));

				
						$fieldset->addField("fname", "text", array(
						"label" => Mage::helper("testview")->__("First Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "fname",
						));
					
						$fieldset->addField("lname", "text", array(
						"label" => Mage::helper("testview")->__("Last Name"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "lname",
						));
					
						$fieldset->addField("email", "text", array(
						"label" => Mage::helper("testview")->__("Email"),					
						"class" => "required-entry",
						"required" => true,
						"name" => "email",
						));
					
						$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(
							Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
						);

						$fieldset->addField('created_at', 'date', array(
						'label'        => Mage::helper('testview')->__('Date Created'),
						'name'         => 'created_at',					
						"class" => "required-entry",
						"required" => true,
						'time' => true,
						'image'        => $this->getSkinUrl('images/grid-cal.gif'),
						'format'       => $dateFormatIso
						));

				if (Mage::getSingleton("adminhtml/session")->getTestviewData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getTestviewData());
					Mage::getSingleton("adminhtml/session")->setTestviewData(null);
				} 
				elseif(Mage::registry("testview_data")) {
				    $form->setValues(Mage::registry("testview_data")->getData());
				}
				return parent::_prepareForm();
		}
}
