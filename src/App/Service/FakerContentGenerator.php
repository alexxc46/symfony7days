<?php

namespace App\Service;

use Faker\Factory as FakerFactory;

class FakerContentGenerator implements ContentGeneratorInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    public function generateTitle(): string
    {
        return $this->faker->sentence(mt_rand(4, 6));
    }

    public function generateContent(): string
    {
        return $this->faker->paragraphs(1, true);
    }
}