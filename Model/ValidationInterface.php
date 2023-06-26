<?php

namespace Tecno\CustomerUpdate\Model;

interface ValidationInterface
{
    /**
     * @param $data
     *
     * @return bool
     */
    public function isValid($data): bool;
}
