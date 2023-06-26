<?php

namespace Tecno\CustomerUpdate\Console\Command;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tecno\CustomerUpdate\Model\Config;
use Tecno\CustomerUpdate\Model\Process;

class SyncCustomers extends Command
{
    public function __construct(protected State $state,
                                protected CollectionFactory $collection,
                                protected Process $process,
                                protected Config $config,
                                string $name = null)
    {
        parent::__construct($name);
    }

    /**
     * Initialization of the command.
     */
    protected function configure()
    {
        $this->setName('sync-customers');
        $this->setDescription('this cli command used to sync customer with api');
        parent::configure();
    }

    /**
     * CLI command description.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->state->setAreaCode('adminhtml');
        $customerCollectionFactory = $this->collection->create();
        $customerCollectionFactory->addFilter('synced',['eq' => 0]);
        $customerCollectionFactory->addFieldToSelect('*');
        $customers = $customerCollectionFactory->getItems();
        if ($customers) {
            foreach ($customers as $customer) {
                try {
                    $this->process->sendToApi($customer);
                } catch (\Exception $exception) {
                    throw $exception;
                }
            }
        }
        $output->writeln('<info>Customers Synced With Api Successfully Check this Url  : '.$this->config->getApiEndpoint().'</info>');

        return 0;
     }
}
