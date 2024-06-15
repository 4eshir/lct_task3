<?php

namespace app\services;

use app\helpers\ApiHelper;

class ApiService
{

    public function checkKey($key)
    {
        return $key == ApiHelper::TEST_API_KEY;
    }
}