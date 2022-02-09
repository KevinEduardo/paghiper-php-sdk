<?php

namespace KevinEduardo\PagHiper\Core\Pix;

use KevinEduardo\PagHiper\Core\Resource;
use KevinEduardo\PagHiper\Core\Exceptions\PagHiperException;

class Pix extends Resource
{
    const PIX_CREATE_ENDPOINT = '/invoice/create';
    const PIX_CANCEL_ENDPOINT = '/invoice/cancel';
    const PIX_STATUS_ENDPOINT = '/invoice/status';
    const PIX_NOTIFICATION_ENDPOINT = '/invoice/notification';


    public function create(array $data)
    {
        $createTransaction = $this->paghiper->request(
            static::PIX_CREATE_ENDPOINT,
            $data
        );

        if ($createTransaction['pix_create_request']['result'] === 'reject') {
            throw new PagHiperException($createTransaction['pix_create_request']['response_message'], 400);
        }

        return $createTransaction;
    }

    public function cancel(string $transaction_id)
    {
        $cancelTransaction = $this->paghiper->request(
            self::PIX_CANCEL_ENDPOINT,
            [
                'transaction_id' => $transaction_id,
                'status' => 'canceled'
            ]
        );

        if ($cancelTransaction['cancellation_request']['result'] === 'reject') {
            throw new PagHiperException($cancelTransaction['cancellation_request']['response_message'], 400);
        }

        return $cancelTransaction;
    }

    public function status(string $transaction_id)
    {
        $transactionStatus = $this->paghiper->request(
            self::PIX_STATUS_ENDPOINT,
            [
                'transaction_id' => $transaction_id,
            ]
        );

        if ($transactionStatus['status_request']['result'] === 'reject') {
            throw new PagHiperException($transactionStatus['status_request']['response_message'], 400);
        }

        return $transactionStatus;
    }

    /**
     *  Get notification response.
     *
     * @return array
     */
    public function notification(string $notificationId, string $transactionId)
    {
        $paymentNotification = $this->paghiper->request(
            static::PIX_NOTIFICATION_ENDPOINT,
            [
                'notification_id' => $notificationId,
                'transaction_id' => $transactionId
            ]
        );

        if ($paymentNotification['status_request']['result'] === 'reject') {
            throw new PagHiperException($paymentNotification['status_request']['response_message'], 400);
        }

        return $paymentNotification;
    }
}
