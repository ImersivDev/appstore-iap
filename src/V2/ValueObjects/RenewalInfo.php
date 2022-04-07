<?php

namespace Imdhemy\AppStore\V2\ValueObjects;

/**
 * Server Notification data
 * @see https://developer.apple.com/documentation/appstoreservernotifications/jwsrenewalinfo
 */
class RenewalInfo
{
    private string $autoRenewProductId;

    /**
     * Possible values are 0, 1
     * @see https://developer.apple.com/documentation/appstoreservernotifications/autorenewstatus
     */
    private int $autoRenewStatus;

    /**
     * Possible values are 1, 2, 3, 4
     * @see https://developer.apple.com/documentation/appstoreservernotifications/expirationintent
     */
    private ?int $expirationIntent;

    private ?Time $gracePeriodExpiresDate;

    private bool $isInBillingRetryPeriod;

    private ?string $offerIdentifier;

    /**
     * Possible values are 1, 2, 3
     * @see https://developer.apple.com/documentation/appstoreservernotifications/offertype
     */
    private ?int $offerType;

    private string $originalTransactionId;

    /**
     * Possible values are 0, 1
     * @see https://developer.apple.com/documentation/appstoreservernotifications/priceincreasestatus
     */
    private ?int $priceIncreaseStatus;

    private string $productId;

    private Time $signedDate;

    public function __construct(
        string $autoRenewProductId,
        int $autoRenewStatus,
        ?int $expirationIntent,
        ?Time $gracePeriodExpiresDate,
        bool $isInBillingRetryPeriod,
        ?string $offerIdentifier,
        ?int $offerType,
        string $originalTransactionId,
        ?int $priceIncreaseStatus,
        string $productId,
        Time $signedDate
    ) {
        $this->autoRenewProductId = $autoRenewProductId;
        $this->autoRenewStatus = $autoRenewStatus;
        $this->expirationIntent = $expirationIntent;
        $this->gracePeriodExpiresDate = $gracePeriodExpiresDate;
        $this->isInBillingRetryPeriod = $isInBillingRetryPeriod;
        $this->offerIdentifier = $offerIdentifier;
        $this->offerType = $offerType;
        $this->originalTransactionId = $originalTransactionId;
        $this->priceIncreaseStatus = $priceIncreaseStatus;
        $this->productId = $productId;
        $this->signedDate = $signedDate;
    }

    public static function parseFromSignedJWS(string $string): self
    {
        $components = explode(".", $string);
        $payload = (array) json_decode(base64_decode($components[1]));

        return new self(
            $payload['autoRenewProductId'],
            $payload['autoRenewStatus'],
            $payload['expirationIntent'] ?? null,
            isset($payload['gracePeriodExpiresDate']) ? new Time($payload['gracePeriodExpiresDate']) : null,
            $payload['isInBillingRetryPeriod'] ?? false,
            $payload['offerIdentifier'] ?? null,
            $payload['offerType'] ?? null,
            $payload['originalTransactionId'],
            $payload['priceIncreaseStatus'] ?? null,
            $payload['productId'],
            new Time($payload['signedDate']),
        );
    }

    public function getAutoRenewProductId()
    {
        return $this->autoRenewProductId;
    }

    public function getAutoRenewStatus()
    {
        return $this->autoRenewStatus;
    }

    public function getExpirationIntent()
    {
        return $this->expirationIntent;
    }

    public function getGracePeriodExpiresDate()
    {
        return $this->gracePeriodExpiresDate;
    }

    public function getIsInBillingRetryPeriod()
    {
        return $this->isInBillingRetryPeriod;
    }

    public function getOfferIdentifier()
    {
        return $this->offerIdentifier;
    }

    public function getOfferType()
    {
        return $this->offerType;
    }

    public function getOriginalTransactionId()
    {
        return $this->originalTransactionId;
    }

    public function getPriceIncreaseStatus()
    {
        return $this->priceIncreaseStatus;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getSignedDate()
    {
        return $this->signedDate;
    }
}
