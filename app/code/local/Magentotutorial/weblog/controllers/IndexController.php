<?php
class Magentotutorial_Weblog_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        //echo 'Setup!';
        $this->loadLayout();
        $this->renderLayout();
    }
} 
