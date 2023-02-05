<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Plugin\Quote\Model\Quote\Address\CustomAttributeList;

use Magento\Eav\Model\AttributeRepository;
use Magento\Quote\Model\Quote\Address\CustomAttributeListInterface;
use Test\TrackingEmail\Block\Widget\TrackingEmail;

class AddCustomAttribute
{
    public function __construct(
        private readonly AttributeRepository $attributeRepository
    ) {
    }

    public function afterGetAttributes(CustomAttributeListInterface $subject, array $result): array
    {
        $result[TrackingEmail::ATTRIBUTE_CODE] = $this->attributeRepository->get(
            'customer_address',
            TrackingEmail::ATTRIBUTE_CODE
        );

        return $result;
    }
}
