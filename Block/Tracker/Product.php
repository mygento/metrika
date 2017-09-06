<?php

namespace Mygento\Metrika\Block\Tracker;

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
        $currentProduct = $this->getRegistry('current_product');
        if (!$currentProduct || !$this->getConfig('ecommerce')) {
            return '';
        }
        $prodData = [
            'id' => $currentProduct->getSku(),
            'name' => $currentProduct->getName(),
            'price' => round($currentProduct->getFinalPrice(), 2),
        ];
        if ($this->getRegistry('current_category')) {
            $prodData['category'] = $this->getRegistry('current_category')
                ->getName();
        }
        $data = [
            'ecommerce' => [
                'detail' => [
                    'products' => [$prodData]
                ]
            ]
        ];
        return '<script>' . $this->getConfig('container_name') . '.push(' .
        $this->jsonEncode($data) .
        ');</script>' . "\n";
    }
}
