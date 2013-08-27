<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table test_view (test_view_id int not null auto_increment, fname varchar(100), lname varchar(100), email varchar(100), created_at timestamp, primary key(test_view_id));
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 