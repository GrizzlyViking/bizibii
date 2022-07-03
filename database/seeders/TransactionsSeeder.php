<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
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
        $user->accounts()->first()->transactions()->saveMany(Transaction::factory(1000)->make());
    }
}
