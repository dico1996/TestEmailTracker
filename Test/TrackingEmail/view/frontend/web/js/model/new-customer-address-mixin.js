define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (newCustomerAddressFunction) {
        return wrapper.wrap(newCustomerAddressFunction, function (originalnewCustomerAddressFunction, addressData) {
            var result = originalnewCustomerAddressFunction(addressData);
            if (!result.customAttributes) {
                result.customAttributes = [];
            }

            result.customAttributes.push({
                attribute_code: 'tracking_email',
                value: addressData.tracking_email
            });

            return result;
        });
    };
});