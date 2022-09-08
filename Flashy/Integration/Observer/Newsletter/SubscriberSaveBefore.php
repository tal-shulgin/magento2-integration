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

	protected $_request;

    /**
     * SubscriberSaveBefore constructor.
     *
     * @param Data $helper
     */
    public function __construct(
		Data $helper,
		\Magento\Framework\App\RequestInterface $request
	)
    {

        $this->helper = $helper;
		$this->_request = $request;
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
                $this->helper->subscriberSend($this->_request->getPostValue(), $subscriber->getStoreId());
            }
        }
    }
}
