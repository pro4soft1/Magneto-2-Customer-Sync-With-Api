<?php

namespace Tecno\CustomerUpdate\Model\Validations;

use Magento\Store\Model\StoreManagerInterface;
use Tecno\CustomerUpdate\Model\Config;
use Tecno\CustomerUpdate\Model\ValidationInterface;

/**
 * Class IsEnabled
 *
 * @package \Tecno\CustomerUpdate\Model\Validator\Order
 */
class IsEnabled implements ValidationInterface
{
    public function __construct(protected Config $config, protected StoreManagerInterface $storeManager)
    {
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function isValid($data): bool
    {
        return $this->config->IsCustomerSyncEnabled();
    }

    public function getMessages(): array
    {
        return [];
    }
}
