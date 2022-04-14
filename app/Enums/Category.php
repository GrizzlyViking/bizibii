<?php

namespace App\Enums;

enum Category: string
{
    case Transport = 'transport';
    case Income = 'income';
    case Entertainment = 'Entertainment';
    case Utilities = 'utilities';
    case Miscellaneous = 'miscellaneous';
    case Communication = 'communication';
    case Financial = 'financial';
    case House = 'house';
}
