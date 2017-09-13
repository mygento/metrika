<?php
/**
 * @author Mygento Team
 * @copyright 2017 Mygento (https://www.mygento.ru)
 * @package Mygento_Metrika
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
        $item = $observer->getEvent()->getQuoteItem();
        $product = $item->getProduct();
        $data = [
            'ecommerce' => [
                'remove' => [
                    'products' => [
                        'id' => (string)$this->_baseHelper->getAttrValueByParam(
                            'metrika/general/skuAttr',
                            $product->getId()
                        ),
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
        $sessionData = $this->_session->getMetrika();
        if ($sessionData && is_array($sessionData)) {
            $sessionData[] = $data;
            return $this->_session->setMetrika($sessionData);
        }
        return $this->_session->setMetrika([$data]);
    }
}
