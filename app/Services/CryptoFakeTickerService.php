<?php

namespace App\Services;

use Exception;
use Faker\Factory;

/**
 * Class CryptoFakeTickerService
 * @package App\Services
 */
class CryptoFakeTickerService
{
    /**
     * Exchange rates
     *
     * @return array
     * @throws Exception
     */
    public function getRates(): array
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[$i] = [
                'name' => strtolower($faker->name),
                'unit' => strtoupper($faker->name),
                'value' => '',
                'type' => 'crypto'
            ];
        }

        return $data;
    }
}
