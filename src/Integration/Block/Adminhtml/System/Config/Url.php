<?php

namespace Flashy\Integration\Block\Adminhtml\System\Config;

use Flashy\Integration\Helper\Data;
use Magento\Backend\Block\AbstractBlock;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Url extends AbstractBlock implements RendererInterface
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
        //get store id from get request
        $scope_id = $this->_request->getParam("store", 0);

        //get flashy api key
        $flashy_key = $this->helper->getFlashyKey();

        //get base url
        $base_url = $this->helper->getBaseUrlByScopeId($scope_id);

        $html = '<table>';
        $entities = array('products', 'contacts', 'orders');
        foreach ($entities as $entity) {
            $flashy_url = $base_url . "flashy?export=$entity&store_id=$scope_id&limit=100&page=1&flashy_pagination=true&flashy_key=$flashy_key";
            $html .= '<tr><td class="label">' . __("Flashy " . ucfirst($entity) . " Url") . '</td>';
            $html .= '<td class="value"><a href="' . $flashy_url . '" target="_blank">' . $flashy_url . '</a></td><td></td></tr>';
        }
        $html .= '</table>';

        return $html;
    }
}
