<?php
/**
 * @author Mygento Team
 * @copyright 2017 Mygento (https://www.mygento.ru)
 * @package Mygento_Metrika
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
    
    /**
     * @var \Mygento\Base\Helper\Data
     */
    protected $_baseHelper;
    
    public function __construct(
        \Magento\Framework\Session\SessionManagerInterface $session,
        \Mygento\Base\Helper\Data $baseHelper
    ) {
        $this->_session = $session;
        $this->_baseHelper = $baseHelper;
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
        $qty = $params['qty'];
        if (!isset($params['qty']) || $params['qty'] == 0) {
            $qty = 1;
        }
        
        $data = [
            'ecommerce' => [
                'add' => [
                    'products' => [
                        'id' => $this->_baseHelper->getAttributeValue(
                            'skuAttr',
                            $product->getId(),
                            'metrika/general/'
                        ),
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
        $sessionData = $this->_session->getMetrika();
        if ($sessionData && is_array($sessionData)) {
            $sessionData[] = $data;
            return $this->_session->setMetrika($sessionData);
        }
        return $this->_session->setMetrika([$data]);
    }
}
