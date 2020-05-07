<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 11);            
            $table->integer('user_status_id')->unsigned();
            $table->integer('user_type_id')->unsigned();            
            $table->foreign('user_status_id')->references('id')->on('user_statuses');
            $table->foreign('user_type_id')->references('id')->on('user_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {            
            $table->dropColumn('phone');
            $table->dropForeign('users_user_status_id_foreign');
            $table->dropForeign('users_user_type_id_foreign');
            $table->dropColumn('user_status_id');            
            $table->dropColumn('user_type_id');                   
        });
    }
}
