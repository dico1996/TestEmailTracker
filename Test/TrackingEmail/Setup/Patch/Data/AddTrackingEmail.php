<?php

declare(strict_types=1);

namespace Test\TrackingEmail\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class AddTrackingEmail implements DataPatchInterface
{
    private const CUSTOMER_ADDRESS_ENTITY = 'customer_address';

    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly CustomerSetupFactory $customerSetupFactory
    ) {
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply()
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(
            self::CUSTOMER_ADDRESS_ENTITY,
            'tracking_email',
            [
                'type' => 'varchar',
                'label' => 'Tracking e-mail address',
                'input' => 'text',
                'required' => true,
                'visible' => true,
                'frontend_class' => 'validate-email',
                'system' => false,
            ]
        );

        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(self::CUSTOMER_ADDRESS_ENTITY, 'tracking_email')
            ->addData([
                    'used_in_forms' => [
                        'adminhtml_customer_address',
                        'adminhtml_customer',
                        'customer_address_edit',
                        'customer_register_address',
                        'customer_address',
                    ]
                ]
            );
        $attribute->save();
    }
}
