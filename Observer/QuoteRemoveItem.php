<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mygento\Metrika\Observer;

/**
 * Class QuoteRemoveItem
 * @package Mygento\Metrika\Observer
 */
class QuoteRemoveItem implements \Magento\Framework\Event\ObserverInterface
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
        $item = $observer->getEvent()->getQuoteItem();
        $product = $item->getProduct();
        $data = [
            'ecommerce' => [
                'remove' => [
                    'products' => [
                        'id' => $product->getSku(),
                        'name' => $product->getName(),
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
