<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\Models\User $user */
        $user = User::where('email', 'sebastian@edelmann.co.uk')->first();
        $user->bankAccounts()->save(BankAccount::factory()->make());
    }
}
