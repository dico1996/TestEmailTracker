<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Plugin\Customer\Model\Metadata\Form;

use Magento\Customer\Model\Metadata\Form;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Api\ExtensibleDataInterface;
use Test\TrackingEmail\Block\Widget\TrackingEmail;

class BeforeSaveAttribute
{
    public function afterCompactData(Form $subject, array $result): array
    {
        if (isset($result[TrackingEmail::ATTRIBUTE_CODE])) {
            $result[ExtensibleDataInterface::EXTENSION_ATTRIBUTES_KEY][TrackingEmail::ATTRIBUTE_CODE] =
                $result[TrackingEmail::ATTRIBUTE_CODE];
        }

        return $result;
    }
}
