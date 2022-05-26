<?php

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('description');
            $table->string('category');
            $table->float('amount');
            $table->boolean('applied')->default(false);
            $table->string('frequency');
            $table->string('due_date');
            $table->string('due_date_meta')
                ->nullable(true)
                ->comment('if custom due date is used.');
            $table->date('start')->nullable(true);
            $table->date('end')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }

};
