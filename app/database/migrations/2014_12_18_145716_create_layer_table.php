<?php

use Illuminate\Database\Migrations\Migration;

class CreateLayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$layer = new Layer();
		Schema::create($layer->getTable(), function($table) {
			$table->increments('id');
			$table->integer('geodata_id')->unsigned();
			$table->string('name');
			$table->string('title');
			$table->unique(array('geodata_id', 'name'));
			$geodata = new Geodata();
			$table->foreign('geodata_id')->references('id')->on($geodata->getTable())->onDelete('CASCADE')->onChange('CASCADE');
		});
		// PostGIS
		DB::statement("ALTER TABLE ".$layer->getTable()." ADD COLUMN bbox GEOGRAPHY(POLYGON,4326)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$layer = new Layer();
		Schema::drop($layer->getTable());
	}

}
