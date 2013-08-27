<?php

class Bestylish_Testview_Block_Adminhtml_Testview_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("testviewGrid");
				$this->setDefaultSort("test_view_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("testview/testview")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("test_view_id", array(
				"header" => Mage::helper("testview")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "test_view_id",
				));
                
				$this->addColumn("fname", array(
				"header" => Mage::helper("testview")->__("First Name"),
				"index" => "fname",
				));
				$this->addColumn("lname", array(
				"header" => Mage::helper("testview")->__("Last Name"),
				"index" => "lname",
				));
				$this->addColumn("email", array(
				"header" => Mage::helper("testview")->__("Email"),
				"index" => "email",
				));
					$this->addColumn('created_at', array(
						'header'    => Mage::helper('testview')->__('Date Created'),
						'index'     => 'created_at',
						'type'      => 'datetime',
					));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/view", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('test_view_id');
			$this->getMassactionBlock()->setFormFieldName('test_view_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_testview', array(
					 'label'=> Mage::helper('testview')->__('Remove Testview'),
					 'url'  => $this->getUrl('*/adminhtml_testview/massRemove'),
					 'confirm' => Mage::helper('testview')->__('Are you sure?')
				));
			return $this;
		}
			

}
