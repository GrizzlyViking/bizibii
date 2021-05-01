<?php

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('pages', function (Blueprint $blueprint) {
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
