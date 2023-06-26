<?php

namespace Tecno\CustomerUpdate\Model;

use Exception;
use GuzzleHttp\Client;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Customer;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\App\ResourceConnection;
use Tecno\CustomerUpdate\Logger\Logger;

/**
 * Class Service
 *
 * @package \Tecno\CustomerUpdate\Model
 */
class Service
{

    public function __construct(protected Client                                         $client,
                                protected DataProvider\Customer                          $customerDataProvider,
                                protected Config                                         $config,
                                protected \Magento\Customer\Model\ResourceModel\Customer $customerResourceModel,
                                protected CustomerRepositoryInterface                    $customerRepository,
                                protected ResourceConnection                             $connection,
                                protected Logger                                         $logger
    )
    {
    }

    /**
     * @param \Magento\Customer\Model\Customer $customer
     *
     * @return bool
     * @throws \Exception
     */
    public function send($customer): bool
    {
        $data = $this->customerDataProvider->prepareData($customer);
        $this->logger->info(sprintf('Preparing Customer Email : %s Data', $customer->getEmail()), $data);
        $requestOptions = [
            'body' => json_encode($data),
            'headers' => [
                'content-type' => 'application/json'
            ],

        ];

        try {

            $this->logger->info(sprintf('Sending Customer Email : %s Data to the Api', $customer->getEmail()), $data);
            $response = $this->client->post($this->config->getApiEndpoint(), $requestOptions);
            if ($response->getStatusCode() === 201) {
                $this->logger->info(sprintf('Customer Email : %s Is Synced Successfully With Api And Response Is : %s', $customer->getEmail(), $response->getBody()));
                $this->UpdateCustomerSynced($customer);
            }

        } catch (GuzzleException $exception) {
            $this->logger->info(sprintf('Customer Email : %s  Synced Error  : %s', $customer->getEmail()), $exception->getMessage());

            return false;
        }
        return false;
    }

    private function UpdateCustomerSynced($customer)
    {
        $connection = $this->connection->getConnection();
        $email = $customer->getEmail();
        $isSynced = 1;
        $query = "UPDATE customer_entity SET synced = $isSynced WHERE email = '$email'";
        $connection->query($query);
    }
}
