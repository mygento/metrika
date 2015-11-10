<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker_Product extends Mage_Core_Block_Template
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('mygento/metrika/product.phtml');
    }

    protected function _toHtml()
    {
        $currentProduct = Mage::registry('current_product');
        if (!$currentProduct) {
            return '';
        }
        return parent::_toHtml();
    }
}
