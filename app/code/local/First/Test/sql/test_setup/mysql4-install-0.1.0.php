<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table test (test_id int not null auto_increment, name varchar(100), primary key(test_id));
    insert into test values(1,'test1');
    insert into test values(2,'test2');
		
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 