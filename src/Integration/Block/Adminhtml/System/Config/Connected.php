<?php

namespace Flashy\Integration\Block\Adminhtml\System\Config;

use Flashy\Integration\Helper\Data;
use Magento\Backend\Block\AbstractBlock;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Store\Model\ScopeInterface;

class Connected extends AbstractBlock implements RendererInterface
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * @var Http
     */
    protected $_request;

    /**
     * Url constructor.
     *
     * @param Http $request
     * @param Data $helper
     */
    public function __construct(
        Http $request,
        Data $helper
    )
    {
        $this->_request = $request;
        $this->helper = $helper;
    }

    /**
     * Render element html
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $store = $this->_request->getParam("website", 0);
        if ($store > 0) {
            $scope = ScopeInterface::SCOPE_WEBSITE;
        } else {
            $store = $this->_request->getParam("store", 0);
            $scope = ScopeInterface::SCOPE_STORE;
        }
        $flashy_connected = $this->helper->getFlashyConnected($scope, $store);
        $html = '<table><tr><td class="label"></td><td class="value"><span class="flashy-' . ($flashy_connected ? '' : 'not-') . 'connected"> ' . __(($flashy_connected ? 'C' : 'Not c') . 'onnected with Flashy.') . '</span></td><td></td></tr></table>';
        return $html;
    }
}
