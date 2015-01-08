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
 * Initial migration for the geodata table.
 * Creates the geodata table.
 */
class CreateGeodataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$geodata = new Geodata();
		$tableName = $geodata->getTable();
		Schema::create($tableName, function($table) {
			$table->increments('id');
			$table->string('datatype');
			$table->string('url')->unique();
			$table->text('title');
			$table->text('abstract')->nullable();
			$table->text('keywords')->nullable();
			$table->text('author')->nullable();
			$table->text('copyright')->nullable();
			$table->text('license')->nullable();
			$table->datetime('begin')->nullable();
			$table->datetime('end')->nullable();
			$table->string('language', 2)->nullable();
		});
		// PostGIS
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN bbox GEOGRAPHY(POLYGON,4326)");
		// Fulltext search
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN searchtext TSVECTOR");
		DB::statement("CREATE INDEX searchtext_gin_{$tableName} ON {$tableName} USING GIN(searchtext)");
		DB::statement("CREATE TRIGGER ts_searchtext_{$tableName} BEFORE INSERT OR UPDATE ON {$tableName} FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.simple', 'title', 'abstract', 'keywords', 'author', 'copyright', 'license')");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$geodata = new Geodata();
		Schema::drop($geodata->getTable());
	}

}
