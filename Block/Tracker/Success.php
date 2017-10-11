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
    protected $checkoutSession;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Mygento\Base\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($coreRegistry, $jsonHelper, $helper, $context, $data);
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Render Metrika tracking success scripts
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @return string
     */
    protected function _toHtml()
    {
        $order = $this->checkoutSession->getLastRealOrder();
        if (!$order->getIncrementId() || !$this->getConfig('ecommerce')) {
            return '';
        }
        $prodData = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $prodData[] = [
                'id' => (string)$this->helper->getAttrValueByParam(
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
