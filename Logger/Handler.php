<?php

namespace Tecno\CustomerUpdate\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class Handler
 *
 * @package \Tecno\CustomerUpdate\Logger
 */
class Handler extends  Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/customers-sync.log';
}
