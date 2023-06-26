<?php

namespace Tecno\CustomerUpdate\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package \Tecno\CustomerUpdate\Model
 */
class Config
{
    const IS_ENABLED_CONFIG_PATH = 'customer_integration/general/is_enabled';
    const IS_ALLOW_SYNC_AFTER_REGISTER_NEW_CUSTOMER_CONFIG_PATH = 'customer_integration/general/allow_sync_after_register';
    const IS_CRON_ENABLED_CONFIG_PATH = 'customer_integration/general/enable_cron';
    const API_ENDPOINT_CONFIG_PATH = 'customer_integration/general/api_endpoint';

    public function __construct(protected ScopeConfigInterface $scopeConfig)
    {
    }

    /**
     * @return bool
     */
    public function IsCustomerSyncEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::IS_ENABLED_CONFIG_PATH);
    }

    /**
     * @return bool
     */
    public function IsAllowedSyncAfterRegister(): bool
    {
        return $this->scopeConfig->isSetFlag(self::IS_ALLOW_SYNC_AFTER_REGISTER_NEW_CUSTOMER_CONFIG_PATH);
    }

    /**
     * @return bool
     */
    public function IsCronEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::IS_CRON_ENABLED_CONFIG_PATH);
    }

    public function getApiEndpoint(): string
    {
        return $this->scopeConfig->getValue(self::API_ENDPOINT_CONFIG_PATH);
    }

}
