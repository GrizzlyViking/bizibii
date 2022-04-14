<?php

use App\Enums\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->string('name');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->string('tag_name');
            $table->morphs('taggable');
        });

        \App\Models\Tag::insert(Tag::all()->map(function(Tag $tag){ return ['name' => $tag->value]; })->toArray());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
};
