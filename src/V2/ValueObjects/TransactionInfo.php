<?php

namespace Imdhemy\AppStore\V2\ValueObjects;

use Imdhemy\AppStore\V2\ValueObjects\Time;

/**
 * Server Notification data
 * @see https://developer.apple.com/documentation/appstoreservernotifications/jwstransaction
 */
class TransactionInfo
{
    private ?string $appAccountToken;

    private string $bundleId;

    private Time $expiresDate;

    private string $inAppOwnershipType;

    private bool $isUpgraded;

    private ?string $offerIdentifier;

    /**
     * Possible values are 1, 2, 3
     * @see https://developer.apple.com/documentation/appstoreservernotifications/offertype
     */
    private ?int $offerType;

    private Time $originalPurchaseDate;

    private string $originalTransactionId;

    private string $productId;

    private Time $purchaseDate;

    private int $quantity;

    private ?Time $revocationDate;

    /**
     * Possible values are 0, 1
     * @see https://developer.apple.com/documentation/appstoreservernotifications/revocationreason
     */
    private ?int $revocationReason;

    private Time $signedDate;

    private string $subscriptionGroupIdentifier;

    private string $transactionId;

    private string $webOrderLineItemId;

    public function __construct(
        ?string $appAccountToken,
        string $bundleId,
        Time $expiresDate,
        string $inAppOwnershipType,
        bool $isUpgraded,
        ?string $offerIdentifier,
        ?int $offerType,
        Time $originalPurchaseDate,
        string $originalTransactionId,
        string $productId,
        Time $purchaseDate,
        int $quantity,
        ?Time $revocationDate,
        ?int $revocationReason,
        Time $signedDate,
        string $subscriptionGroupIdentifier,
        string $transactionId,
        string $webOrderLineItemId
    ) {
        $this->appAccountToken = $appAccountToken;
        $this->bundleId = $bundleId;
        $this->expiresDate = $expiresDate;
        $this->inAppOwnershipType = $inAppOwnershipType;
        $this->isUpgraded = $isUpgraded;
        $this->offerIdentifier = $offerIdentifier;
        $this->offerType = $offerType;
        $this->originalPurchaseDate = $originalPurchaseDate;
        $this->originalTransactionId = $originalTransactionId;
        $this->productId = $productId;
        $this->purchaseDate = $purchaseDate;
        $this->quantity = $quantity;
        $this->revocationDate = $revocationDate;
        $this->revocationReason = $revocationReason;
        $this->signedDate = $signedDate;
        $this->subscriptionGroupIdentifier = $subscriptionGroupIdentifier;
        $this->transactionId = $transactionId;
        $this->webOrderLineItemId = $webOrderLineItemId;
    }

    public static function parseFromSignedJWS(string $string): self
    {
        $components = explode(".", $string);
        $payload = (array) json_decode(base64_decode($components[1]));

        return new self(
            $payload['appAccountToken'] ?? null,
            $payload['bundleId'],
            new Time($payload['expiresDate']),
            $payload['inAppOwnershipType'],
            $payload['isUpgraded'] ?? false,
            $payload['offerIdentifier'] ?? null,
            $payload['offerType'] ?? null,
            new Time($payload['originalPurchaseDate']),
            $payload['originalTransactionId'],
            $payload['productId'],
            new Time($payload['purchaseDate']),
            $payload['quantity'],
            isset($payload['revocationDate']) ? new Time($payload['revocationDate']) : null,
            $payload['revocationReason'] ?? null,
            new Time($payload['signedDate']),
            $payload['subscriptionGroupIdentifier'],
            $payload['transactionId'],
            $payload['webOrderLineItemId'],
        );
    }

    public function getAppAccountToken()
    {
        return $this->appAccountToken;
    }

    public function getBundleId()
    {
        return $this->bundleId;
    }

    public function getExpiresDate()
    {
        return $this->expiresDate;
    }

    public function getInAppOwnershipType()
    {
        return $this->inAppOwnershipType;
    }

    public function getIsUpgraded()
    {
        return $this->isUpgraded;
    }

    public function getOfferIdentifier()
    {
        return $this->offerIdentifier;
    }

    public function getOfferType()
    {
        return $this->offerType;
    }

    public function getOriginalPurchaseDate()
    {
        return $this->originalPurchaseDate;
    }

    public function getOriginalTransactionId()
    {
        return $this->originalTransactionId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getRevocationDate()
    {
        return $this->revocationDate;
    }

    public function getRevocationReason()
    {
        return $this->revocationReason;
    }

    public function getSignedDate()
    {
        return $this->signedDate;
    }

    public function getSubscriptionGroupIdentifier()
    {
        return $this->subscriptionGroupIdentifier;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getWebOrderLineItemId()
    {
        return $this->webOrderLineItemId;
    }
}
