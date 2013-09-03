<?php
$installer = $this;
/* @var $installer Mage_Customer_Model_Entity_Setup */

$installer->startSetup();
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute(
    'customer',
    'is_dealer_agent',
    array(
        'type'                 => 'int',
        'label'                => 'Is Dealer Agent',
        'input'                => 'boolean',
        'required'             => 0,
        'default'              => 0,
        'visible'              => 1,
        'adminhtml_only'       => 1,
        'position'			   => 701,
    )
);
$eavConfig   = Mage::getSingleton('eav/config');
$attribute   = $eavConfig->getAttribute('customer', 'is_dealer_agent');
$usedInForms = array('adminhtml_customer',);
$attribute->setData('used_in_forms', $usedInForms);
$attribute->save();

$installer->endSetup();
