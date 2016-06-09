<?php

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
        array $data = []
    ) {
        parent::__construct($context, $coreRegistry, $jsonHelper, $data);
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
        if (!$order->getIncrementId() || !$this->getConfig('general/ecommerce')) {
            return '';
        }
        $prodData = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $prodData[] = [
                'id' => $item->getSku(),
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
        return '<script>dataLayer.push(' . $this->jsonEncode($data) . ');</script>' . "\n";
    }
}
