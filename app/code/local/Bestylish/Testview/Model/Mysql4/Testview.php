<?php
class Bestylish_Testview_Model_Mysql4_Testview extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("testview/testview", "test_view_id");
    }
}