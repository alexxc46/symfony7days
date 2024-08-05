<?php

namespace App\Service;

interface ContentGeneratorInterface
{
    public function generateTitle(): string;
    public function generateContent(): string;
}