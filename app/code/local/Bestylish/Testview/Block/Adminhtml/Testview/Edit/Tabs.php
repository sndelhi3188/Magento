<?php
class Bestylish_Testview_Block_Adminhtml_Testview_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("testview_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("testview")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("testview")->__("Item Information"),
				"title" => Mage::helper("testview")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("testview/adminhtml_testview_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
