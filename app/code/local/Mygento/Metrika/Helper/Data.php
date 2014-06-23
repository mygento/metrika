<?php

/**
 * Sea Lab Ltd.
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2014 Sea Lab Ltd.
 */
class Mygento_Metrika_Helper_Data extends Mage_Core_Helper_Abstract {

    public function AddLog($text) {
        if (Mage::getStoreConfig('metrika/general/debug')) {
            Mage::log($text);
        }
    }

}
