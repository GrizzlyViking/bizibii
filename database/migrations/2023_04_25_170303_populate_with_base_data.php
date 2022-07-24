<?php

use App\Enums\Category;
use App\Enums\DueDate;
use App\Enums\Frequency;
use App\Models\Account;
use App\Models\Expense;
use App\Models\Page;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class PopulateWithBaseData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var User $user */
        $user = User::createWithPersonalTeam([
            'name' => 'Sebastian Scheel Edelmann',
            'email' => 'sebastian@edelmann.co.uk',
            'password' => Hash::make('Darl1ch10'),
        ]);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => 'Founders',
            'personal_team' => false,
        ]));

        $user->accounts()->create([
            'name' => 'standard account',
            'description' => 'standard account',
            'balance' => 1000
        ]);

        $user->accounts()->create([
            'name' => 'shared account',
            'description' => 'budget account',
            'balance' => 1000
        ]);

        Schema::table('pages', function (Blueprint $table) {
            /** @var Page $page */
            $page = Page::create([
                'title' => 'BiziBii',
                'slug' => 'home',
                'published' => true,
                'access' => ["view" => "all", "edit" => "admin"]
            ]);

            $page->sections()->saveMany([
                new Section([
                    'title' => 'BiziBii',
                    'subtitle' => 'We are Design Studio since 2010',
                    'slug' => 'start',
                    'content' => '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has
                              a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.</p>',
                    'published' => true
                ]),
                new Section([
                    'title' => 'about',
                    'slug' => 'about',
                    'subtitle' => 'A few Words About Us',
                    'content' => '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that
                                  it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop
                                  publishing packages.</p><br>
                                  <p>And web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various
                                  versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>'
                ]),
                new Section([
                    'title' => 'Team',
                    'slug' => 'team',
                    'subtitle' => 'Our Team',
                    'content' => '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that
                                  it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop
                                  publishing packages.</p><br>
                                  <p>And web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various
                                  versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>'
                ])
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Page::where('slug', 'home')->delete();
    }
}
