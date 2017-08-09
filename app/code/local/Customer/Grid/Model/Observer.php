<?php
class Customer_Grid_Model_Observer
{
    /**
     * Adds column to admin customers grid
     *
     * @param Varien_Event_Observer $observer
     * @return Atwix_CustomGrid_Model_Observer
     */
    public function appendCustomColumn($observer)
    {
        $block = $observer->getBlock();
        if (!isset($block)) {
            return $this;
        }

        if ($block->getType() == 'adminhtml/customer_grid') {
            /* @var $block Mage_Adminhtml_Block_Customer_Grid */
            $block->addColumnAfter('middlename', array(
                'header'    => 'Middle Name',
                'type'      => 'text',
                'index'     => 'middlename',
            ), 'email');
        }
    }
}
