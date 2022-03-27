<?php

namespace Flashy\Integration\Observer\Newsletter;

use Flashy\Integration\Helper\Data;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\Subscriber;

class SubscriberSaveBefore implements ObserverInterface
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * SubscriberSaveBefore constructor.
     *
     * @param Data $helper
     */
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Execute observer.
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->getFlashyActive()) {
            $subscriber = $observer->getEvent()->getSubscriber();

            if ($subscriber->getStatus() == Subscriber::STATUS_SUBSCRIBED) {
                $this->helper->subscriberSend($subscriber->getSubscriberEmail(), $subscriber->getStoreId());
            }
        }
    }
}
