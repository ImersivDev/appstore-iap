<?php

namespace Imdhemy\AppStore\V2\ServerNotifications;

use \Imdhemy\AppStore\V2\ValueObjects\ServerNotificationData;

/**
 * App Store Server Notifications
 * @see https://developer.apple.com/documentation/appstoreservernotifications?changes=latest_minor
 */
class ServerNotification
{
    private string $notificationType;
    private ?string $subtype;
    private string $notificationUUID;
    private ?string $notificationVersion;
    private ServerNotificationData $data;

    public function __construct(
        string $notificationType,
        ?string $subtypem,
        string $notificationUUID,
        ?string $notificationVersion,
        ServerNotificationData $data,
    ) {
        $this->notificationType = $notificationType;
        $this->subtypem = $subtypem;
        $this->notificationUUID = $notificationUUID;
        $this->notificationVersion = $notificationVersion;
        $this->data = $data;
    }

    public static function parseFromSignedJWS(string $signedPayload): self
    {
        $signedPayload = $signedPayload;
        $signedPayloadComponents = explode(".", $signedPayload);
        $payloadEncoded = $signedPayloadComponents[1];
        $payload = (array) json_decode(base64_decode($payloadEncoded));
        
        $data = ServerNotificationData::fromArray((array) $payload['data']);

        return new self(
            $payload['notificationType'],
            $payload['subtype'] ?? null,
            $payload['notificationUUID'],
            $payload['notificationVersion'] ?? null,
            $data,
        );
    }

    public function getNotificationType()
    {
        return $this->notificationType;
    }

    public function getSubtype()
    {
        return $this->subtype;
    }

    public function getNotificationUUID()
    {
        return $this->notificationUUID;
    }

    public function getNotificationVersion()
    {
        return $this->notificationVersion;
    }

    public function getData()
    {
        return $this->data;
    }
}
