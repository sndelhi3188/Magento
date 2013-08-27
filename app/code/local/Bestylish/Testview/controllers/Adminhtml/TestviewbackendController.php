<?php
class Bestylish_Testview_Adminhtml_TestviewbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("ViewTest"));
	   $this->renderLayout();
    }
}