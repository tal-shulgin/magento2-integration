<?php
namespace Flashy\Integration\Controller\Cart;

use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
$v = explode('.',$productMetadata->getVersion());

if($v[1] > 2) {
    class Restore extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
    {
        /**
         * @var \Flashy\Integration\Helper\Data
         */
        public $helper;

        /**
         * Index constructor.
         *
         * @param \Magento\Framework\App\Action\Context $context
         * @param \Flashy\Integration\Helper\Data $helper
         */
        public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Flashy\Integration\Helper\Data $helper
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
         * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
         */
        public function execute()
        {
            $key = $this->getRequest()->getParam('id', 0);
            $this->helper->restoreFlashyCartHash($key);
            $this->getResponse()->setRedirect('/checkout/cart/index');
        }
    }
} else {
    class Restore extends \Magento\Framework\App\Action\Action
    {
        /**
         * @var \Flashy\Integration\Helper\Data
         */
        public $helper;

        /**
         * Index constructor.
         *
         * @param \Magento\Framework\App\Action\Context $context
         * @param \Flashy\Integration\Helper\Data $helper
         */
        public function __construct(
            \Magento\Framework\App\Action\Context $context,
            \Flashy\Integration\Helper\Data $helper
        ) {
            $this->helper = $helper;
            parent::__construct($context);
        }

        /**
         * Execute restore action
         *
         * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
         */
        public function execute()
        {
            $key = $this->getRequest()->getParam('id', 0);
            $this->helper->restoreFlashyCartHash($key);
            $this->getResponse()->setRedirect('/checkout/cart/index');
        }
    }
}
