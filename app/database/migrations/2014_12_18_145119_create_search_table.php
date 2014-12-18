<?php

use Illuminate\Database\Migrations\Migration;

class CreateSearchTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$search = new SavedSearch();
		Schema::create($search->getTable(), function($table) {
			$table->string('id', 32)->primary();
			$table->string('keywords');
			$table->tinyInteger('rating')->nullable()->unsigned();
			$table->dateTime('start')->nullable();
			$table->dateTime('end')->nullable();
		});
		DB::statement("ALTER TABLE ".$search->getTable()." ADD COLUMN bbox GEOGRAPHY(POLYGON,4326)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$search = new SavedSearch();
		Schema::drop($search->getTable());
	}

}
