<?php

/**
 * @author Mygento Team
 * @copyright 2017 Mygento (https://www.mygento.ru)
 * @package Mygento_Metrika
 */

namespace Mygento\Metrika\Block;

/**
 * Metrika Page Block
 */
class Tracker extends \Magento\Framework\View\Element\Template
{
    /**
     *  Json
     *
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;
    
    /**
     *  Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    
    /**
     * Session
     *
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        array $data = []
    ) {
        $this->_jsonHelper = $jsonHelper;
        $this->_coreRegistry = $coreRegistry;
        $this->_session = $context->getSession();
        parent::__construct($context, $data);
    }
    
    /**
     * Get Dynamic tracker through events
     * @return array
     */
    public function getDynamicTrackers()
    {
        $data = $this->_session->getMetrika();
        if ($data && is_array($data)) {
            $this->_session->unsMetrika();
            return $data;
        }
        return [];
    }
    
    /**
     *  Get parameters for counter
     *
     * @return array
     */
    public function getOptions()
    {
        $options = [];
        $options['id'] = $this->getCode();
        if ($this->getConfig('webvisor')) {
            $options['webvisor'] = (bool)$this->getConfig('webvisor');
        }
        if ($this->getConfig('clickmap')) {
            $options['clickmap'] = (bool)$this->getConfig('clickmap');
        }
        if ($this->getConfig('tracklinks')) {
            $options['trackLinks'] = (bool)$this->getConfig('tracklinks');
        }
        if ($this->getConfig('accuratetrackbounce')) {
            $options['accurateTrackBounce'] =
                (bool)$this->getConfig('accuratetrackbounce');
        }
        if ($this->getConfig('noindex')) {
            $options['ut'] = 'noindex';
        }
        if ($this->getConfig('ecommerce')) {
            $options['ecommerce'] = $this->getConfig('container_name');
        }
        return $options;
    }
    
    /**
     * Get Tracker Code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->getConfig('counter');
    }
    
    /**
     * Render Metrika tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getConfig('enabled')) {
            return '';
        }
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
        return $this->_scopeConfig->getValue(
            'metrika/general/' . $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
    /**
     * Get data from Registry
     *
     * @param string $name
     * @return mixed
     */
    public function getRegistry($name)
    {
        return $this->_coreRegistry->registry($name);
    }
    
    /**
     * @param $data
     * @return string
     */
    public function jsonEncode($data)
    {
        return $this->_jsonHelper->jsonEncode($data);
    }
}
