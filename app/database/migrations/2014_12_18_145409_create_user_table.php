<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$user = new User();
		Schema::create($user->getTable(), function($table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('password')->nullable();
			$table->string('email')->unique();
			$table->string('language', 2)->nullable();
			$table->rememberToken();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$user = new User();
		Schema::drop($user->getTable());
	}

}
