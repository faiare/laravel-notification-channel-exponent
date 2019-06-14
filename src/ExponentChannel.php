<?php

namespace NotificationChannels\Exponent;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Exponent\Exceptions\CouldNotSendNotification;

/**
 * Class ExponentChannel
 * @package NotificationChannels\Exponent
 */
class ExponentChannel
{
    const DEFAULT_API_URL = 'https://exp.host/--/api/v2';
    const MAX_TOKEN_LENGTH = 100;

    protected $client;

    /**
     * ExponentChannel constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Exponent\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $notifiable->routeNotificationFor('exponent')) {
            return;
        }
        $tokens = (array) $notifiable->routeNotificationFor('exponent');

        if (empty($tokens)) {
            return;
        }

        /** @var ExponentMessage|null $exponentMessage */
        $exponentMessage = $notification->toExponent($notifiable);

        if (empty($exponentMessage)) {
            return;
        }

        $partialTokens = array_chunk($tokens, self::MAX_TOKEN_LENGTH, false);
        foreach ($partialTokens as $partialToken) {
            $exponentMessage->setTokens($partialToken);
            $this->sendExponent($exponentMessage);
        }
    }

    /**
     * @param ExponentMessage $exponentMessage
     */
    protected function sendExponent(ExponentMessage $exponentMessage)
    {
        $request = [];
        foreach ($exponentMessage->getTokens() as $token) {
            $request[] = $exponentMessage->toArray() + ['to' => $token];
        }

        try {
            $this->client->post('/push/send', [
                'body' => json_encode($request),
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);
        } catch (RequestException $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e);
        }
    }
}
