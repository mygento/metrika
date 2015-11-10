<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker_Success extends Mage_Core_Block_Template
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('mygento/metrika/success.phtml');
    }

    protected function _toHtml()
    {
        if (!Mage::getStoreConfig('metrika/metrika/ecommerce')) {
            return '';
        }
        return parent::_toHtml();
    }
}
