<?php
/**
 * @author Mygento Team
 * @copyright 2017 Mygento (https://www.mygento.ru)
 * @package Mygento_Metrika
 */

namespace Mygento\Metrika\Block\Tracker;

/**
 * Metrika Page Block
 */
class Success extends \Mygento\Metrika\Block\Tracker
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;
    
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Mygento\Base\Helper\Data $baseHelper,
        array $data = []
    ) {
        parent::__construct($context, $coreRegistry, $jsonHelper, $baseHelper, $data);
        $this->_checkoutSession = $checkoutSession;
    }
    
    /**
     * Render Metrika tracking success scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        $order = $this->_checkoutSession->getLastRealOrder();
        if (!$order->getIncrementId() || !$this->getConfig('ecommerce')) {
            return '';
        }
        $prodData = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $prodData[] = [
                'id' => (string)$this->_baseHelper->getAttrValueByParam(
                    'metrika/general/skuAttr',
                    $item->getProductId()
                ),
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'quantity' => (int)$item->getQtyOrdered()
            ];
        }
        $data = [
            'ecommerce' => [
                'purchase' => [
                    'actionField' => [
                        'id' => (string)$order->getIncrementId(),
                        'shipping' => $order->getShippingAmount(),
                    ],
                    'products' => [$prodData]
                ]
            ]
        ];
        return '<script>' . $this->getConfig('container_name') . '.push(' .
            $this->jsonEncode($data) .
            ');</script>' . "\n";
    }
}
