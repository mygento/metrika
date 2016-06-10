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

    /**
     * Set or Update Session Data
     *
     * @param $data
     * @return mixed
     */
    public function setSessionData($data)
    {
        $sessionData = Mage::getSingleton('core/session')->getMetrika();
        if ($sessionData && is_array($sessionData)) {
            $sessionData[] = $data;
            return Mage::getSingleton('core/session')->setMetrika($sessionData);
        }
        return Mage::getSingleton('core/session')->setMetrika(array($data));
    }
}
