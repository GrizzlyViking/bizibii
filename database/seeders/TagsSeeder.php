<?php

namespace Database\Seeders;

use App\Enums\Tag;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
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
        $user->accounts()->first()->transactions->map(function (Transaction $transaction) {
            $transaction->addTags(Tag::all()->random(3));
        });
    }
}
