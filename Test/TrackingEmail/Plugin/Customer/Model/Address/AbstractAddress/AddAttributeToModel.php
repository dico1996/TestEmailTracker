<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Plugin\Customer\Model\Address\AbstractAddress;

use Magento\Customer\Model\Address\AbstractAddress;
use Magento\Customer\Model\Data\Address;
use Magento\Customer\Api\Data\AddressExtensionFactory;

class AddAttributeToModel
{
    public function __construct(
        private readonly AddressExtensionFactory $extensionFactory
    )
    {
    }

    public function afterGetDataModel(AbstractAddress $subject, Address $result): Address
    {
        $trackingEmail = $subject->getTrackingEmail();
        if ($trackingEmail) {
            $extensionAttributes = $result->getExtensionAttributes() ?? $this->extensionFactory->create();
            $extensionAttributes->setTrackingEmail($trackingEmail);
            $result->setExtensionAttributes($extensionAttributes);
        }

        return $result;
    }
}
