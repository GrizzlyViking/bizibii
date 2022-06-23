<?php

namespace App\Models;

interface ListableInterface
{
    public function getColumn1(): string;

    public function getColumn1Sub(): ?string;

    public function getColumn2(): ?string;

    public function getColumn3(): ?string;

    public function getColumn4(): ?string;

    public function getRouteShow(): ?string;
}
