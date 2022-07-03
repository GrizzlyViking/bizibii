<?php

use App\Models\Account;
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
            $table->foreignIdFor(Account::class)->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('category');
            $table->float('amount', 16, 2);
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
