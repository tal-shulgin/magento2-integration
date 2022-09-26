<?php
declare(strict_types=1);

namespace Flashy\Integration\Observer\Newsletter;

use Flashy\Integration\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\ResourceModel\CustomerRepositoryFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Newsletter\Model\Subscriber;

class SubscriberSaveAfter implements ObserverInterface
{
    private Data $helper;
    private CustomerRepositoryFactory $customerRepositoryFactory;

    /**
     * @param Data $helper
     * @param CustomerRepositoryFactory $customerRepositoryFactory
     */
    public function __construct(
        Data $helper,
        CustomerRepositoryFactory $customerRepositoryFactory
    ) {
        $this->helper = $helper;
        $this->customerRepositoryFactory = $customerRepositoryFactory;
    }

    /**
     * @inheritdoc
     *
     * @event newsletter_subscriber_save_after
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->helper->getFlashyActive()) {
            return;
        }

        /** @var Subscriber $subscriber */
        $subscriber = $observer->getEvent()->getSubscriber();
        if ($subscriber->getStatus() !== Subscriber::STATUS_SUBSCRIBED) {
            return;
        }

        $subscriberData = [
            'email' => $subscriber->getEmail(),
        ];

        try {
            /** @var CustomerRepositoryInterface $customerRepository */
            $customerRepository = $this->customerRepositoryFactory->create();
            $customerDataModel = $customerRepository->getById((int)$subscriber->getCustomerId());

            $defaultBillingAddress = null;

            /** @var AddressInterface $address */
            foreach ($customerDataModel->getAddresses() ?: [] as $address) {
                if ($address->getId() === $customerDataModel->getDefaultBilling()) {
                    $defaultBillingAddress = $address;
                    break;
                }
            }

            if ($defaultBillingAddress !== null) {
                $subscriberData['telephone'] = $defaultBillingAddress->getTelephone();
                $subscriberData['firstname'] = $defaultBillingAddress->getFirstname();
                $subscriberData['lastname'] = $defaultBillingAddress->getLastname();
                $subscriberData['dob'] = $customerDataModel->getDob();
                $subscriberData['city'] = $defaultBillingAddress->getCity();
                $subscriberData['street'] = $defaultBillingAddress->getStreet();
            }
        } catch (\Exception $e) {
            // TODO: implement logic to handle Exceptions
        }

        $this->helper->subscriberSend($subscriberData, $subscriber->getStoreId());
    }
}
