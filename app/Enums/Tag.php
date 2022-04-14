<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Tag: string implements TaxonomyInterface
{

    case Food = 'food';

    case Interest = 'interest';

    case Insurance = 'insurance';

    case Mortgage = 'mortgage';

    case Medicine = 'medicine';

    case Car = 'car';

    case Salary = 'salary';

    case Child = 'child';

    case StreamingService = 'streaming service';

    case Pension = 'pension';

    case BookAndMagazineSubscription = 'book and magazine subscription';

    case LoanRepayment = 'loan repayment';

    case PublicTransport = 'public transport';

    public function category(): Category
    {
        return match ($this) {
            Tag::Car, Tag::PublicTransport => Category::Transport,
            Tag::Pension, Tag::LoanRepayment, Tag::Interest, Tag::Insurance, Tag::Mortgage => Category::Financial,
            Tag::BookAndMagazineSubscription, Tag::StreamingService => Category::Entertainment,
            Tag::Food, Tag::Medicine, Tag::Child => Category::Miscellaneous
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
        ]);
    }
}
