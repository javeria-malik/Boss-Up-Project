<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
