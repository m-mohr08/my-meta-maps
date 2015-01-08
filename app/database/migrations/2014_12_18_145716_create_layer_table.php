<?php
/* 
 * Copyright 2014/15 Matthias Mohr
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Illuminate\Database\Migrations\Migration;

/**
 * Initial migration for the layer table.
 * Creates the layer table.
 */
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
