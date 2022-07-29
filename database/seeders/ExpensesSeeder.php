<?php

namespace Database\Seeders;

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpensesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = User::find(1);

        /** @var Account $account_standard */
        $account_standard = $user->accounts->where('name', 'standard account')->first();
        $account_shared = $user->accounts->where('name', 'shared account')->first();

        $account_standard->checkpoints()->create([
            'registered_date' => '2022-07-24',
            'amount'      => 2459.14,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Income,
            'description' => 'Wages from aller',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastWorkingDayOfMonth,
            'start'       => '2021-11-01',
            'amount'      => 33633.00,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::House,
            'description' => 'Tryg',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 2190,
        ]);

        $account_shared->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 5697.00,
        ]);

        $account_shared->expenses()->create([
            'category'    => Category::House,
            'description' => 'Mortgage',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-03-01',
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 8134.00,
        ]);

        /** @var Expense $energy */
        $energy = $account_standard->expenses()->create([
            'category'    => Category::Utilities,
            'description' => 'Electricity and gas',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 4403.00,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2021-09-07',
            'amount'      => 1957.19,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2021-10-07',
            'amount'      => 2463.78,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2021-11-08',
            'amount'      => 3160.82,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2021-12-07',
            'amount'      => 3622.01,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-01-07',
            'amount'      => 4697.35,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-02-07',
            'amount'      => 5225.21,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-03-07',
            'amount'      => 2772.73,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-04-07',
            'amount'      => 3590.28,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-05-09',
            'amount'      => 6915.51,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-06-07',
            'amount'      => 3184.20,
        ]);

        $energy->checkpoints()->create([
            'registered_date' => '2022-07-07',
            'amount'      => 9478.95,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Transport,
            'description' => 'Electric car - Lease plan',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 3410.00,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Miscellaneous,
            'description' => 'Det faglige hus',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 565,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'Carolinas Telia mobile account',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 140.98,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'Ikano (washing machine)',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 437,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Entertainment,
            'description' => 'Netflix',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 140.34,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Entertainment,
            'description' => 'Amazon video',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 45,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Entertainment,
            'description' => 'Various bills to apple',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 524,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'Cyberghost',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '3rd of month',
            'amount'      => 113.21,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'Laracast',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '3rd of month',
            'amount'      => 119,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'Ring monthly plan',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '5th of month',
            'amount'      => 30.14,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Communication,
            'description' => 'NordVPN',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '10th of month',
            'amount'      => 90.29,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Income,
            'description' => 'Overførsel Børne- og Ungeydelse',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-10-20',
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '20th',
            'amount'      => 1841,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Utilities,
            'description' => 'EVIDA SERVICE NORD A',
            'frequency'   => Frequency::Every3rdMonth,
            'start'       => '2021-10-06',
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '6th in month',
            'amount'      => 2385.90,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Tax,
            'description' => 'Council tax',
            'frequency'   => Frequency::Every6thMonth,
            'start'       => '2021-01-01',
            'due_date'    => DueDate::DateInMonth,
            'due_date_meta' => '7th in month',
            'amount'      => 6660.90,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Transport,
            'description' => 'Clever',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::FirstWorkingDayOfMonth,
            'amount'      => 200,
        ]);

        $account_standard->expenses()->create([
            'category'    => Category::Transfer,
            'transfer_to_account_id' => $account_shared->id,
            'description' => 'Transfer to budget account',
            'frequency'   => Frequency::Monthly,
            'due_date'    => DueDate::LastDayOfMonth,
            'amount'      => 13000,
        ]);
    }
}
