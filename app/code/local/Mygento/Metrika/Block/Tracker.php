<?php

/**
 * Sea Lab Ltd.
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2014 Sea Lab Ltd.
 */
class Mygento_Metrika_Block_Tracker extends Mage_Core_Block_Template {

    public function Basic1() {
        return '
        <!-- Yandex.Metrika counter -->
        <script>
            (function(d, w, c) {
                (w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter7828540 = new Ya.Metrika({id: 7828540, enableAll: true, webvisor: true});
        ';
    }

    public function Basic2() {
        return '
            } catch (e) {
                    }
                });

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
        <noscript><div><img src="//mc.yandex.ru/watch/7828540" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        ';
    }

    public function toDefault() {
        $html = '';
        $html.=$this->Basic1();
        $html.=$this->Basic2();
        return $html;
    }

    public function toProduct() {
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

    public function toCategory() {
        $html = '';
        $_category = Mage::registry('current_category');
        $html.=$this->Basic1();
        $name = str_replace('"', '', $_category->getName());
        $html.='category';
        $html.=$this->Basic2();
        return $html;
    }

    public function toCart() {
        $html = '';
        $html.=$this->Basic1();
        $session = Mage::getSingleton('checkout/session');
        foreach ($session->getQuote()->getAllItems() as $item) {
            $_product = $item->getProduct();
            $categories = array();
            $cats = $_product->getCategoryIds();
            foreach ($cats as $category_id) {
                $_cat = Mage::getModel('catalog/category')->load($category_id);
                $categories[] = $_cat->getName();
            }
            $name = str_replace('"', '', $item->getName());
            $sku = str_replace('"', '', $item->getSku());
            $html.='cart';
        }
        $grandTotal = Mage::getModel('checkout/cart')->getQuote()->getGrandTotal();
        if ($grandTotal) {
            $html.='piwikTracker.trackEcommerceCartUpdate('.$grandTotal.');'.PHP_EOL;
        }
        $html.=$this->Basic2();
        return $html;
    }

    public function toSuccess() {
        $html = '';

        $session = Mage::getSingleton('checkout/session');
        $lastid = Mage::getSingleton('checkout/type_onepage')->getCheckout()->getLastOrderId();
        $order = Mage::getSingleton('sales/order');
        $order->load($lastid);

        if (Mage::getStoreConfig('mystats/piwik/enabled')) {
            $html.=$this->Basic1();

            foreach ($order->getAllItems() as $item) {
                $categories = array();
                $cats = $item->getCategoryIds();
                if (count($cats)) {
                    foreach ($cats as $category_id) {
                        $_cat = Mage::getModel('catalog/category')->load($category_id);
                        $categories[] = $_cat->getName();
                    }
                }
                $qty = '0';
                $qty = number_format($item->getQtyOrdered(), 0, '.', '');
                $html.='success';
            }

            $subtotal = $order->getGrandTotal() - $order->getShippingAmount() - $order->getShippingTaxAmount();
            $html.='success2'.PHP_EOL;

            $html.=$this->Basic2();
        }
        
        return $html;
    }

    protected function _toHtml() {
        $html = '';
        if (Mage::getStoreConfig('mystats/general/enabled')) {
            if (Mage::getStoreConfig('mystats/piwik/enabled')) {
                $type = '';
                $type = $this->getData('viewpage');
                switch ($type) {
                    case 'product':
                        $html.=$this->toProduct();
                        break;
                    case 'category':
                        $html.=$this->toCategory();
                        break;
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
        }
        return $html;
    }

    protected function _prepareLayout() {
        return parent::_prepareLayout();
    }

}
