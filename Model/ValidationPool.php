<?php

namespace Tecno\CustomerUpdate\Model;

/**
 * Class ValidationPool
 *
 * @package \Tecno\CustomerUpdate\Model
 */
class ValidationPool
{
    /**
     * @var \Tecno\CustomerUpdate\Model\ValidationInterface[] $validations
     */
    protected array $validations = [];

    public function __construct($validations = [])
    {
        $this->validations = $validations;
    }

    /**
     * @param $customer
     *
     * @return bool
     */
    public function validate($customer): bool
    {
        foreach ($this->validations as $validation) {
            if (!$validation->isValid($customer)) {
                return false;
            }
        }
        return true;
    }

}
