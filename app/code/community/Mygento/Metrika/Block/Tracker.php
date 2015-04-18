<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Block_Tracker extends Mage_Core_Block_Template
{

    public function Basic1()
    {
        $options = array();
        $options['id'] = intval(Mage::getStoreConfig('metrika/metrika/counter'));
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
        return '
        <!-- Yandex.Metrika counter -->
        <script>
            (function(d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter' . $options['id'] . ' = new Ya.Metrika(' . json_encode($options) . ');
                ';
    }

    public function Basic2()
    {
        return '} catch (e) {}});
            
                var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function() {
                    n.parentNode.insertBefore(s, n);
                };
                s.type = "text/javascript";
                s.async = true;
                s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                if (w.opera == "[object Opera]") {
                    d.addEventListener("DOMContentLoaded", f);
                } else {
                    f();
                }
            })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript><div><img src="//mc.yandex.ru/watch/' . intval(Mage::getStoreConfig('metrika/metrika/counter')) . '" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        ';
    }

    public function toDefault()
    {
        $html = '';
        $html.=$this->Basic1();
        $html.=$this->Basic2();
        return $html;
    }

    public function toProduct()
    {
        $html = '';
        $_product = Mage::registry('current_product');
        $_category = Mage::registry('current_category');
        $name = str_replace('"', '', $_product->getName());
        $sku = str_replace('"', '', $_product->getSku());

        $categories = array();
        $cats = $_product->getCategoryIds();
        foreach ($cats as $category_id) {
            $_cat = Mage::getModel('catalog/category')->load($category_id);
            $categories[] = $_cat->getName();
        }
        $html.=$this->Basic1();
        // add the first product to the order
        $html.='product';

        $html.=$this->Basic2();

        return $html;
    }

    public function toCategory()
    {
        $html = '';
        $_category = Mage::registry('current_category');
        $html.=$this->Basic1();
        $name = str_replace('"', '', $_category->getName());
        $html.='category';
        $html.=$this->Basic2();
        return $html;
    }

    public function toCart()
    {
        $html = '';
        $html.=$this->Basic1();
        $options = array();
        $session = Mage::getSingleton('checkout/session');
        if (count($session->getQuote()->getAllItems())) {
            $options['currency'] = Mage::app()->getStore()->getCurrentCurrencyCode();
            $options['exchange_rate'] = 1;
            $options['goods'] = array();
            foreach ($session->getQuote()->getAllItems() as $item) {
                $options['goods'][] = array('id' => $item->getSku(), 'name' => $item->getName(), 'price' => $item->getBaseCalculationPrice(), 'quantity' => $item->getQty());
            }
        }
        $grandTotal = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal();
        if ($grandTotal) {
            $options['order_price'] = $grandTotal;
        }
        $html.='w.yaCounter' . intval(Mage::getStoreConfig('metrika/metrika/counter')) . '.reachGoal(\'cart\',' . json_encode($options) . ');';
        $html.=$this->Basic2();
        return $html;
    }

    public function toSuccess()
    {
        $html = '';

        //$session = Mage::getSingleton('checkout/session');
        $lastid = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId();
        $order = Mage::getSingleton('sales/order');
        $order->load($lastid);
        $options = array();

        $html.=$this->Basic1();
        $options['order_id'] = (string) $order->getIncrementId();
        $options['currency'] = Mage::app()->getStore()->getCurrentCurrencyCode();
        $options['exchange_rate'] = 1;
        $options['goods'] = array();
        $options['order_price'] = $order->getGrandTotal();

        foreach ($order->getAllVisibleItems() as $item) {
            $options['goods'][] = array('id' => $item->getSku(), 'name' => $item->getName(), 'price' => $item->getPrice(), 'quantity' => (int) $item->getQtyOrdered());
        }
        $html.='w.yaCounter' . intval(Mage::getStoreConfig('metrika/metrika/counter')) . '.params(' . json_encode($options) . ');';

        $html.=$this->Basic2();
        return $html;
    }

    protected function _toHtml()
    {
        $html = '';
        if (Mage::getStoreConfig('metrika/metrika/enabled')) {
            $type = '';
            $type = $this->getData('viewpage');
            switch ($type) {
                /*
                  case 'product':
                  $html.=$this->toProduct();
                  break;
                  case 'category':
                  $html.=$this->toCategory();
                  break;
                 */
                case 'cart':
                    $html.=$this->toCart();
                    break;
                case 'order':
                    $html.=$this->toSuccess();
                    break;
                default:
                    $html.=$this->toDefault();
            }
        }

        return $html;
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}
