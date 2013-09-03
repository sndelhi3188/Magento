<?php
require_once "/var/www/magento/app/Mage.php";
Varien_Profiler::enable();
Mage::setIsDeveloperMode(true);
ini_set('display_errors',1);
umask(0);

Mage::app('default');

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->startSetup();

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$setup->addAttribute('customer', 'is_dealer_agent', array(
    'input'         => 'boolean',
    'type'          => 'int',
    'label'         => 'is_dealer_agent',
    'visible'       => true,
    'required'      => false,
    'default'       => '0',
    'user_defined'  => true,
));

$setup->addAttributeToGroup(
 $entityTypeId,
 $attributeSetId,
 $attributeGroupId,
 'is_dealer_agent',
 '100'  //sort_order
);


$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'is_dealer_agent');
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));

$oAttribute->save();
$setup->endSetup();


