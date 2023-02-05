<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Plugin\Customer\Model\Address;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\Address;
use Test\TrackingEmail\Block\Widget\TrackingEmail;

class ExtractAttributeFromExtension
{
    public function afterUpdateData(Address $subject, $result)
    {
        $extensionAttributes = $result->getExtensionAttributes();
        if ($extensionAttributes && isset($extensionAttributes[TrackingEmail::ATTRIBUTE_CODE])) {
            $result->setData(TrackingEmail::ATTRIBUTE_CODE, $extensionAttributes[TrackingEmail::ATTRIBUTE_CODE]);
        }

        return $result;
    }
}
