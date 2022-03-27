<?php

namespace Flashy\Integration\Model\Config\Backend;

use Flashy\Integration\Helper\Data;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class FlashyKey extends Value
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param Data $helper
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context              $context,
        Registry             $registry,
        ScopeConfigInterface $config,
        TypeListInterface    $cacheTypeList,
        Data                 $helper,
        AbstractResource     $resource = null,
        AbstractDb           $resourceCollection = null,
        array                $data = []
    )
    {
        $this->helper = $helper;

        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        if (!(($this->getValue() == '') || ($this->helper->checkApiKey($this->getValue())))) {
            throw new ValidatorException(__('Flashy API Key is not valid.'));
        }

        $this->setValue($this->getValue());

        parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->getValue() == '') {
            $value = 0;
        } else {
            $value = $this->helper->connectionRequest($this->getScope(), $this->getScopeId());
        }
        $this->helper->setFlashyConnected($value, $this->getScope(), $this->getScopeId());

        return parent::afterSave();
    }

    public function afterDelete()
    {
        $this->helper->removeFlashyConnected($this->getScope(), $this->getScopeId());

        return parent::afterDelete();
    }
}
