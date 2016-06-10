<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mygento\Metrika\Observer;

/**
 * Class AddToCart
 * @package Mygento\Metrika\Observer
 */
class AddToCart implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Session
     *
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;

    public function __construct(
        \Magento\Framework\Session\SessionManagerInterface $session
    ) {
        $this->_session = $session;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $request = $observer->getEvent()->getRequest();
        $params = $request->getParams();
        $qty = (!isset($params['qty']) || $params['qty'] == 0 ? 1 : $params['qty']);
        $data = [
            'ecommerce' => [
                'add' => [
                    'products' => [
                        'id' => $product->getSku(),
                        'name' => $product->getName(),
                        'price' => $product->getPrice(),
                        //"brand" => "Яндекс / Яndex",
                        //"category" => "Аксессуары/Сумки",
                        'quantity' => $qty,
                    ]
                ]
            ]
        ];
        $this->setSessionData($data);
    }

    /**
     * Set or Update Session Data
     *
     * @param $data
     * @return mixed
     */
    protected function setSessionData($data)
    {
        $session_data = $this->_session->getMetrika();
        if ($session_data && is_array($session_data)) {
            $session_data[] = $data;
            return $this->_session->setMetrika($session_data);
        }
        return $this->_session->setMetrika([$data]);
    }
}
