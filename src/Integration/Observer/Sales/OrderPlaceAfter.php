<?php

namespace Flashy\Integration\Observer\Sales;

use Flashy\Integration\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderPlaceAfter implements ObserverInterface
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * OrderPlaceAfter constructor.
     *
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $this->helper->orderPlace($order);
    }
}
