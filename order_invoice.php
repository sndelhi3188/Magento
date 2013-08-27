<?php
require_once 'app/Mage.php';
Mage::app('default');
$store = Mage::app()->getStore('default');
$customer = Mage::getModel('customer/customer');
$customer->setStore($store);
$customer->loadByEmail('sudheer4u@live.com');
$quote = Mage::getModel('sales/quote');
$quote->setStore($store);
$quote->assignCustomer($customer);
$product1 = Mage::getModel('catalog/product')->load(166); /* HTC Touch Diamond */
//print_r($product1);
$buyInfo1 = array('qty' => 1);
$product2 = Mage::getModel('catalog/product')->load(18); /* Sony Ericsson W810i */
$buyInfo2 = array('qty' => 3);
$quote->addProduct($product1, new Varien_Object($buyInfo1));
$quote->addProduct($product2, new Varien_Object($buyInfo2));
$billingAddress = $quote->getBillingAddress()->addData($customer->getPrimaryBillingAddress());
$shippingAddress = $quote->getShippingAddress()->addData($customer->getPrimaryShippingAddress());
$shippingAddress->setCollectShippingRates(true)->collectShippingRates()
                ->setShippingMethod('flatrate_flatrate')
                ->setPaymentMethod('checkmo');
$quote->getPayment()->importData(array('method' => 'checkmo'));
$quote->collectTotals()->save();
$service = Mage::getModel('sales/service_quote', $quote);
$service->submitAll();
$order = $service->getOrder();
echo "order created sucessfully.";
echo "</br>";
$invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
$invoice->register();
$transaction = Mage::getModel('core/resource_transaction')
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder());
$transaction->save();
echo "Invoiced Sucessfully.";
