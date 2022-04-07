<?php

namespace Imdhemy\AppStore\V2\ValueObjects;

/**
 * Server Notification data
 * @see https://developer.apple.com/documentation/appstoreservernotifications/data
 */
class ServerNotificationData
{
    private ?string $appAppleId;

    private string $bundleId;

    private string $bundleVersion;

    /**
     * Possible values: Sandbox, Production
     */
    private string $environment;

    private TransactionInfo $transactionInfo;

    private RenewalInfo $renewalInfo;

    public function __construct(
        ?string $appAppleId,
        string $bundleId,
        string $bundleVersion,
        string $environment,
        TransactionInfo $transactionInfo,
        RenewalInfo $renewalInfo
    ) {
        $this->appAppleId = $appAppleId;
        $this->bundleId = $bundleId;
        $this->bundleVersion = $bundleVersion;
        $this->environment = $environment;
        $this->transactionInfo = $transactionInfo;
        $this->renewalInfo  = $renewalInfo;
    }

    public static function fromArray(array $array): self
    {
        $transactionInfo = TransactionInfo::parseFromSignedJWS($array['signedTransactionInfo']);
        $renewalInfo = RenewalInfo::parseFromSignedJWS($array['signedRenewalInfo']);

        return new self(
            $array['appAppleId'] ?? null,
            $array['bundleId'],
            $array['bundleVersion'],
            $array['environment'],
            $transactionInfo,
            $renewalInfo,
        );
    }

    public function getAppAppleId(): ?string
    {
        return $this->appAppleId;
    }

    public function getBundleId(): string
    {
        return $this->bundleId;
    }

    public function getBundleVersion(): string
    {
        return $this->bundleVersion;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function getTransactionInfo(): TransactionInfo
    {
        return $this->transactionInfo;
    }

    public function getRenewalInfo(): RenewalInfo
    {
        return $this->renewalInfo;
    }
}
