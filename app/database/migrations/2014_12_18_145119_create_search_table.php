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
 * Initial migration for the search/permalink table.
 * Creates the search/permalink table.
 */
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
			$table->boolean('metadata');
			$table->tinyInteger('rating')->nullable()->unsigned();
			$table->dateTime('start')->nullable();
			$table->dateTime('end')->nullable();
			$table->integer('radius')->nullable();
		});
		// PostGIS
		DB::statement("ALTER TABLE ".$search->getTable()." ADD COLUMN location GEOGRAPHY(POINT,4326)");
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
