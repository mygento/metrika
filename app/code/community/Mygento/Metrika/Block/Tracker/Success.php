<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker_Success extends Mage_Core_Block_Template
{

    protected function _toHtml()
    {
        if (!Mage::getStoreConfig('metrika/metrika/ecommerce')) {
            return '';
        }
        $lastid = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId();
        $order = Mage::getSingleton('sales/order')->load($lastid);
        $prod_data = array();
        foreach ($order->getAllVisibleItems() as $item) {
            $prod_data[] = array(
                'id' => $item->getSku(),
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'quantity' => (int) $item->getQtyOrdered()
            );
        }
        $data = array(
            'ecommerce' => array(
                'purchase' => array(
                    'actionField' => array(
                        'id' => (string) $order->getIncrementId(),
                        'shipping' => $order->getShippingAmount(),
                    ),
                    'products' => $prod_data,
                )
            )
        );
        return '<script>dataLayer.push(' . Mage::helper('core')->jsonEncode($data) . ');</script>' . "\n";
    }
}
