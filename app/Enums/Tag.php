<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Tag: string implements EnumInterface
{

    case Food = 'food';

    case Interest = 'interest';

    case Insurance = 'insurance';

    case Mortgage = 'mortgage';

    case Medicine = 'medicine';

    case CouncilTax = 'council tax';

    case Car = 'car';

    case Salary = 'salary';

    case Child = 'child';

    case StreamingService = 'streaming service';

    case Pension = 'pension';

    case BookAndMagazineSubscription = 'book and magazine subscription';

    case LoanRepayment = 'loan repayment';

    case PublicTransport = 'public transport';

    case Unknown = 'unknown';

    public function category(): Category
    {
        return match ($this) {
            self::Car,
            self::PublicTransport => Category::Transport,
            self::Pension,
            self::LoanRepayment,
            self::Interest,
            self::Insurance,
            self::Mortgage => Category::Financial,
            self::BookAndMagazineSubscription,
            self::StreamingService => Category::Entertainment,
            self::Food,
            self::Medicine,
            self::Child => Category::Miscellaneous,
            self::Salary => Category::Income,
            self::CouncilTax => Category::Tax,
            self::Unknown => Category::Unknown
        };
    }

    public static function all(): Collection
    {
        return collect([
            self::Food,
            self::Interest,
            self::Insurance,
            self::Mortgage,
            self::Medicine,
            self::Car,
            self::Salary,
            self::Child,
            self::StreamingService,
            self::Pension,
            self::BookAndMagazineSubscription,
            self::LoanRepayment,
            self::PublicTransport,
            self::Unknown,
        ]);
    }

    public function equals(EnumInterface|string $enum): bool
    {
        if ($enum instanceof EnumInterface) {
            return $this->value == $enum->value && $this->name == $enum->name;
        }

        return $this->value == $enum || $this->name == $enum;
    }
}
