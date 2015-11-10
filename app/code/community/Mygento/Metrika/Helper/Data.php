<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function addLog($text)
    {
        if (Mage::getStoreConfig('metrika/general/debug')) {
            Mage::log($text);
        }
    }

    public function getCode()
    {
        return Mage::getStoreConfig('metrika/metrika/counter');
    }
}
