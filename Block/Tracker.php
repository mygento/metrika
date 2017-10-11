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
    protected $jsonHelper;

    /**
     *  Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Session
     *
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $session;

    /**
     * @var \Mygento\Base\Helper\Data
     */
    protected $helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Mygento\Base\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Mygento\Base\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsonHelper = $jsonHelper;
        $this->coreRegistry = $coreRegistry;
        $this->session = $context->getSession();
        $this->helper = $helper;
    }

    /**
     * Get Dynamic tracker through events
     * @return array
     */
    public function getDynamicTrackers()
    {
        $data = $this->session->getMetrika();
        if ($data && is_array($data)) {
            $this->session->unsMetrika();
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
        if ($this->getConfig('trackhash')) {
            $options['trackhash'] = (bool)$this->getConfig('trackhash');
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
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
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
        return $this->helper->getConfig('metrika/general/' . $path);
    }

    /**
     * Get data from Registry
     *
     * @param string $name
     * @return mixed
     */
    public function getRegistry($name)
    {
        return $this->coreRegistry->registry($name);
    }

    /**
     * @param $data
     * @return string
     */
    public function jsonEncode($data)
    {
        return $this->jsonHelper->jsonEncode($data);
    }
}
