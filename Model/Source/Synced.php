<?php

namespace Tecno\CustomerUpdate\Model\Source;

/**
 * Class Synced
 *
 * @package \Tecno\CustomerUpdate\Model\Source
 */
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Eav\Model\Entity\Attribute\Source\SourceInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Synced extends AbstractSource implements OptionSourceInterface, SourceInterface
{
    /**
     * @return array|array[]|null
     */
    public function getAllOptions(): ?array
    {
        if (!$this->_options) {
            $this->_options = [
                [
                    'label' => __('Synced'),
                    'value' => 1
                ],
                [
                    'label' => __('Not synced'),
                    'value' => 0
                ]
            ];
        }

        return $this->_options;
    }
}
