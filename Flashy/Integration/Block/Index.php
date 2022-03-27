<?php

namespace Flashy\Integration\Block;

use Flashy\Integration\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Data $helper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data    $helper,
        array   $data = []
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Get flashy id.
     *
     * @return mixed
     */
    public function getFlashyId()
    {
        return $this->helper->getFlashyId();
    }

    /**
     * Get flashy purchase.
     *
     * @return mixed
     */
    public function getFlashyPurchase()
    {
        return $this->helper->getFlashyPurchase();
    }

    /**
     * Get current order data.
     *
     * @return array
     */
    public function getOrderDetails()
    {
        return $this->helper->getOrderDetails();
    }
}
