<?php

namespace Mygento\Metrika\Block;

/**
 * Metrika Page Block
 */
class Tracker extends \Magento\Framework\View\Element\Template
{
    /**
     *  Get parameters for counter
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();
        $options['id'] = $this->getCode();
        if ($this->getConfig('metrika/general/webvisor')) {
            $options['webvisor'] = (bool) $this->getConfig('metrika/general/webvisor');
        }
        if ($this->getConfig('metrika/general/clickmap')) {
            $options['clickmap'] = (bool) $this->getConfig('metrika/general/clickmap');
        }
        if ($this->getConfig('metrika/general/tracklinks')) {
            $options['trackLinks'] = (bool) $this->getConfig('metrika/general/tracklinks');
        }
        if ($this->getConfig('metrika/general/accuratetrackbounce')) {
            $options['accurateTrackBounce'] = (bool) $this->getConfig('metrika/general/accuratetrackbounce');
        }
        if ($this->getConfig('metrika/general/ecommerce')) {
            $options['ecommerce'] = (bool) $this->getConfig('metrika/general/ecommerce');
        }
    }

    /**
     * Get Tracker Code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getConfig('metrika/general/counter');
    }

    /**
     * Render GA tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        //if(!$this->getConfig('metrika/general/enabled')){
        //    return '';
        //}
        return parent::_toHtml();
    }

    /**
     * Get config
     *
     * @param string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
