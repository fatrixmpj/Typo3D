<?php

namespace Omnipay\Wirecard;

/**
 * Wirecard (driver for Omnipay
 */

use Omnipay\Common\AbstractGateway as OmnipayAbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;

abstract class AbstractGateway extends OmnipayAbstractGateway
{
    // Shared gateway/message properties.
    use CommonParametersTrait;

    /**
     * 
     */
    public function getDefaultParameters()
    {
        return array(
            // Required. The merchant ID.
            'customerId' => '',
            // Required if more than one shop is in the account.
            'shopId' => '',
            // Pre-share key used to hash data.
            'secret' => '',
            // Required.
            'language' => 'en',
            // For backend Page functions.
            'toolkitPassword' => '',
            // For backend Seamless functions (will default to toolkitPassword).
            'password' => '',
            // Return URL after auth failure.
            'failureUrl' => '',
            // Link to terms of service.
            'serviceUrl' => '',
        );
    }
}
