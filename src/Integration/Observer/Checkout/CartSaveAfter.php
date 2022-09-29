<?php

namespace Flashy\Integration\Observer\Checkout;

use Flashy\Integration\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CartSaveAfter implements ObserverInterface
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * CartSaveAfter constructor.
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
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->getFlashyActive()) {
            $cart = $observer->getEvent()->getCart();
            $this->helper->updateFlashyCartHash($cart);
        }
    }
}
