<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker_Product extends Mage_Core_Block_Template
{

    protected function _toHtml()
    {
        $currentProduct = Mage::registry('current_product');
        if (!$currentProduct || !Mage::getStoreConfig('metrika/metrika/ecommerce')) {
            return '';
        }

        $prod_data = array(
            'id' => $currentProduct->getSku(),
            'name' => $currentProduct->getName(),
            'price' => round($currentProduct->getFinalPrice(), 2),
        );
        if (Mage::registry('current_category')) {
            // TODO CATEGORY BREADCRUMBS
            // "category": "Одежда/Мужская одежда/Футболки",
            $prod_data['category'] = Mage::registry('current_category')->getName();
        }
        // TODO brand and variant
        //'brand' => '',
        //'variant' => '',
        $data = array(
            'ecommerce' => array(
                'detail' => array(
                    'products' => array(
                        $prod_data
                    )
                )
            )
        );

        return '<script>dataLayer.push(' . Mage::helper('core')->jsonEncode($data) . ');</script>' . "\n";
    }
}
