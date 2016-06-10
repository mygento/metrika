<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Model_Observer
{

    public function addToCartComplete($observer)
    {
        $product = $observer->getProduct();
        $params = $observer->getRequest()->getParams();
        if (!isset($params['qty']) || $params['qty'] == 0) {
            $qty = 1;
        } else {
            $qty = $params['qty'];
        }
        $data = array(
            'ecommerce' => array(
                'add' => array(
                    'products' => array(
                        'id' => $product->getSku(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        //'brand' => 'Яндекс / Яndex',
                        //'category' => 'Аксессуары/Сумки',
                        'quantity' => $qty,
                    )
                )
            )
        );
        Mage::helper('metrika')->setSessionData($data);
    }

    public function removeFromCartComplete($observer)
    {
        $product = $observer->getQuoteItem()->getProduct();
        $data = array(
            'ecommerce' => array(
                'remove' => array(
                    'products' => array(
                        'id' => $product->getSku(),
                        'name' => $product->getName(),
                    )
                )
            )
        );
        Mage::helper('metrika')->setSessionData($data);
    }

    public function removeDomainPolicyHeader($observer)
    {
        /** @var Mage_Core_Controller->getCurrentAreaDomainPolicy_Varien_Action $action */
        $action = $observer->getControllerAction();

        if ('frontend' == $action->getLayout()->getArea()) {
            /** @var Mage_Core_Controller_Response_Http $response */
            $response = $action->getResponse();
            // @codingStandardsIgnoreStart
            $url = parse_url(Mage::helper('core/http')->getHttpReferer());
            // codingStandardsIgnoreEnd
            if ($url && isset($url['host']) && $url['host'] == 'webvisor.com') {
                $response->clearHeader('X-Frame-Options');
            }
        }

        return $this;
    }
}
