<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('permission_id');
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('role_id');
            $table->primary(['user_id', 'role_id']);
        });

        Schema::create('permission_user', function (Blueprint $table) {
            //FOREIGN KEY CONSTRAINTS
            $table->foreignId('user_id');
            $table->foreignId('permission_id');

            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('role_user');
    }
}
