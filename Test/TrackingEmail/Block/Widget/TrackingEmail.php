<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Block\Widget;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Helper\Address as AddressHelper;
use Magento\Customer\Model\Options;
use Magento\Framework\View\Element\Template\Context;

class TrackingEmail extends AbstractWidget
{
    public const ATTRIBUTE_CODE = 'tracking_email';

    public function __construct(
        Context $context,
        AddressHelper $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        private readonly AddressMetadataInterface $addressMetadata,
        array $data = []
    ) {
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
    }
    public function _construct(): void
    {
        parent::_construct();
        $this->setTemplate('Test_TrackingEmail::widget/tracking.phtml');
    }

    protected function _getAttribute($attributeCode)
    {
        if ($this->getForceUseCustomerAttributes() || $this->getObject() instanceof CustomerInterface) {
            return parent::_getAttribute($attributeCode);
        }

        try {
            $attribute = $this->addressMetadata->getAttributeMetadata($attributeCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }

        if ($this->getForceUseCustomerRequiredAttributes() && $attribute && !$attribute->isRequired()) {
            $customerAttribute = parent::_getAttribute($attributeCode);
            if ($customerAttribute && $customerAttribute->isRequired()) {
                $attribute = $customerAttribute;
            }
        }

        return $attribute;
    }

    public function getStoreLabel(): string
    {
        $attribute = $this->_getAttribute(self::ATTRIBUTE_CODE);

        return $attribute ? __($attribute->getStoreLabel())->render() : '';
    }

    public function getAttributeValidationClass(string $attributeCode): string
    {
        return $this->_addressHelper->getAttributeValidationClass($attributeCode);
    }

    public function isEnabled(): bool
    {
        $attributeMetadata = $this->_getAttribute(self::ATTRIBUTE_CODE);

        return $attributeMetadata && $attributeMetadata->isVisible();
    }

    public function isRequired(): bool
    {
        $attributeMetadata = $this->_getAttribute(self::ATTRIBUTE_CODE);

        return $attributeMetadata && $attributeMetadata->isRequired();
    }
}
