<?php

namespace App\Console\Commands;

use App\Enums\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateTaxonomy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:taxonomy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Based on Tag and Category Enum update taxonomy table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // tags taken from database
        $tags_db = DB::table('tags')->get('name')->map(function($tag){return $tag->name;});

        $tags_diff = Tag::all()->map(function(Tag $tag){ return $tag->value; });

        $tags_db->diff($tags_diff)->each(function($tag) {
            DB::table('tags')->where('name', $tag)->delete();
        });

        // missing
        Tag::all()->each(function (Tag $tag) use ($tags_db) {
            if ($tags_db->doesntContain($tag->value)) {
                \App\Models\Tag::insert(['name' => $tag->value]);
            }
        });

        return 0;
    }
}
