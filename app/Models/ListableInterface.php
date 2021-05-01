<?php

namespace App\Models;

interface ListableInterface
{
    public function getTitle(): string;

    public function getSubtitle(): string;

    public function getName(): string;

    public function getPosition(): string;

    public function getContent(int $char_limit = 20): string;

    public function getRouteShow(): string;
}
