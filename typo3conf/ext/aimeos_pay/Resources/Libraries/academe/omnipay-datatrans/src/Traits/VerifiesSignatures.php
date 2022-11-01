<?php

namespace Omnipay\Datatrans\Traits;

/**
 * Provides a signature verifier.
 * Used by the CompleteRequest before generating the response,
 * and the AcceptNotification on an adhoc way.
 */

use Omnipay\Datatrans\Gateway;
use Exception;

trait VerifiesSignatures
{

    /**
     * TODO: PaypalOrderId=get adds a string
     * TODO: support XML settlement messages
     *
     * @throws Exception
     */
    public function assertSignature()
    {
        if ($this->getDataItem('status') !== 'success') {
            // The sign2 signature is only provided if the result is a success.

            return;
        }

        $sign2 = $this->getDataItem('sign2', '');

        // The signature will have been generated by either the sign2 or the sign key.

        $key = $this->getHmacKey();

        $data = [
            $this->getDataItem('merchantId', ''),
            $this->getDataItem('amount', '0'),
            $this->getDataItem('currency', ''),
            $this->getDataItem('uppTransactionId', ''),
        ];

        // TODO: Plus "PayPalOrderId" if PaypalOrderId=get (not difference in letter case).

        $calculatedSign2 = hash_hmac('SHA256', implode('', $data), hex2bin($key));

        $isValid = ($sign2 === $calculatedSign2);

        if (! $isValid) {
            throw new Exception(sprintf(
                'The "sign2" signature of this message from the gateway is invalid; expecting "%s" got "%s"',
                $calculatedSign2,
                $sign2
            ));
        }
    }
}