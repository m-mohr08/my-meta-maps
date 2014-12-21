<?php

use Illuminate\Database\Migrations\Migration;

class CreateBasemapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$basemap = new Basemap();
		Schema::create($basemap->getTable(), function($table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('url')->unique();
			$table->boolean('active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$basemap = new Basemap();
		Schema::drop($basemap->getTable());
	}

}
