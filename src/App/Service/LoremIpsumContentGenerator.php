<?php

namespace App\Service;

use joshtronic\LoremIpsum;

class LoremIpsumContentGenerator implements ContentGeneratorInterface
{
    private LoremIpsum $loremIpsum;

    public function __construct(LoremIpsum $loremIpsum)
    {
        $this->loremIpsum = $loremIpsum;
    }

    public function generateTitle(): string
    {
        return $this->loremIpsum->words(mt_rand(4, 6));
    }

    public function generateContent(): string
    {
        return $this->loremIpsum->paragraphs(2);
    }
}