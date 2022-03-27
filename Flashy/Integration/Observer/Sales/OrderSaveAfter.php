<?php

namespace Flashy\Integration\Observer\Sales;

use Flashy\Integration\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderSaveAfter implements ObserverInterface
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * OrderSaveAfter constructor.
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
        try {
            $order = $observer->getEvent()->getOrder();
            $this->helper->orderSend($order);
        } catch (\Exception $e) {
            $this->helper->showMessage($e->getMessage());
        }
    }
}
