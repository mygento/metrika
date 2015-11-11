<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker extends Mage_Core_Block_Template
{

    public function getCode()
    {
        return Mage::helper('metrika')->getCode();
    }

    /**
     *  Get parameters for counter
     *
     */
    public function getOptions()
    {
        $options = array();
        $options['id'] = $this->getCode();
        if (Mage::getStoreConfig('metrika/metrika/webvisor')) {
            $options['webvisor'] = (bool) Mage::getStoreConfig('metrika/metrika/webvisor');
        }
        if (Mage::getStoreConfig('metrika/metrika/clickmap')) {
            $options['clickmap'] = (bool) Mage::getStoreConfig('metrika/metrika/clickmap');
        }
        if (Mage::getStoreConfig('metrika/metrika/tracklinks')) {
            $options['trackLinks'] = (bool) Mage::getStoreConfig('metrika/metrika/tracklinks');
        }
        if (Mage::getStoreConfig('metrika/metrika/accuratetrackbounce')) {
            $options['accurateTrackBounce'] = (bool) Mage::getStoreConfig('metrika/metrika/accuratetrackbounce');
        }
        if (Mage::getStoreConfig('metrika/metrika/ecommerce')) {
            $options['ecommerce'] = (bool) Mage::getStoreConfig('metrika/metrika/ecommerce');
        }
    }

    protected function _toHtml()
    {
        if (!Mage::getStoreConfig('metrika/general/enabled')) {
            return '';
        }
        return parent::_toHtml();
    }
}
