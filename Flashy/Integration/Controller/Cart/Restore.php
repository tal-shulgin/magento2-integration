<?php

namespace Flashy\Integration\Controller\Cart;

use Flashy\Integration\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

$objectManager = ObjectManager::getInstance();
$productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
$v = explode('.', $productMetadata->getVersion());

if ($v[1] > 2) {
    class Restore extends Action implements CsrfAwareActionInterface
    {
        /**
         * @var Data
         */
        public $helper;

        /**
         * Restore constructor.
         *
         * @param Context $context
         * @param Data $helper
         */
        public function __construct(
            Context $context,
            Data    $helper
        )
        {
            $this->helper = $helper;
            parent::__construct($context);
        }

        public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
        {
            return null;
        }

        public function validateForCsrf(RequestInterface $request): ?bool
        {
            return true;
        }

        /**
         * Execute restore action
         *
         * @return ResponseInterface|ResultInterface|void
         */
        public function execute()
        {
            $key = $this->getRequest()->getParam('id', 0);
            $this->helper->restoreFlashyCartHash($key);
            $this->getResponse()->setRedirect('/checkout/cart/index');
        }
    }
} else {
    class Restore extends Action
    {
        /**
         * @var Data
         */
        public $helper;

        /**
         * Restore constructor.
         *
         * @param Context $context
         * @param Data $helper
         */
        public function __construct(
            Context $context,
            Data    $helper
        )
        {
            $this->helper = $helper;
            parent::__construct($context);
        }

        /**
         * Execute restore action
         *
         * @return ResponseInterface|ResultInterface|void
         */
        public function execute()
        {
            $key = $this->getRequest()->getParam('id', 0);
            $this->helper->restoreFlashyCartHash($key);
            $this->getResponse()->setRedirect('/checkout/cart/index');
        }
    }
}
