<?php

namespace Mygento\Metrika\Block;

/**
 * Metrika Page Block
 */
class Tracker extends \Magento\Framework\View\Element\Template
{
    /*
     *  Json
     *
     *  @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /*
     *  Registry
     *
     *  @var \Magento\Framework\Registry
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
        return array();
    }

    /**
     *  Get parameters for counter
     *
     * @return array
     */
    public function getOptions()
    {
        $options = array();
        $options['id'] = $this->getCode();
        if ($this->getConfig('general/webvisor')) {
            $options['webvisor'] = (bool)$this->getConfig('general/webvisor');
        }
        if ($this->getConfig('general/clickmap')) {
            $options['clickmap'] = (bool)$this->getConfig('general/clickmap');
        }
        if ($this->getConfig('general/tracklinks')) {
            $options['trackLinks'] = (bool)$this->getConfig('general/tracklinks');
        }
        if ($this->getConfig('general/accuratetrackbounce')) {
            $options['accurateTrackBounce'] = (bool)$this->getConfig('general/accuratetrackbounce');
        }
        if ($this->getConfig('general/ecommerce')) {
            $options['ecommerce'] = (bool)$this->getConfig('general/ecommerce');
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
        return $this->getConfig('general/counter');
    }

    /**
     * Render Metrika tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getConfig('general/enabled')) {
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
            'metrika/' . $path,
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
