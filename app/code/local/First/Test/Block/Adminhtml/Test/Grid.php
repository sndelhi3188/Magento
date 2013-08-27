<?php

class First_Test_Block_Adminhtml_Test_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("testGrid");
				$this->setDefaultSort("test_id");
				$this->setDefaultDir("ASC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("test/test")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("test_id", array(
				"header" => Mage::helper("test")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "test_id",
				));
                
				$this->addColumn("name", array(
				"header" => Mage::helper("test")->__("name"),
				"index" => "name",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('test_id');
			$this->getMassactionBlock()->setFormFieldName('test_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_test', array(
					 'label'=> Mage::helper('test')->__('Remove Test'),
					 'url'  => $this->getUrl('*/adminhtml_test/massRemove'),
					 'confirm' => Mage::helper('test')->__('Are you sure?')
				));
			return $this;
		}
			

}