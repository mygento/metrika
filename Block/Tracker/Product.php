<?php namespace Mygento\Metrika\Block\Tracker;

/**
 * Metrika Page Block
 */
class Product extends \Mygento\Metrika\Block\Tracker
{

    /**
     * Render Metrika tracking product scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        $currentProduct = $this->_coreRegistry->registry('current_product');
        if (!$currentProduct || !$this->getConfig('metrika/general/ecommerce')) {
            return '';
        }
        $prod_data = [
            'id' => $currentProduct->getSku(),
            'name' => $currentProduct->getName(),
            'price' => round($currentProduct->getFinalPrice(), 2),
        ];
        $data = [
            'ecommerce' => [
                'detail' => [
                    'products' => [$prod_data]
                ]
            ]
        ];
        return '<script>dataLayer.push(' . $this->helper('Magento\Framework\Json\Helper\Data')->jsonEncode($data) . ');</script>;';
    }
}
