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
 * Initial migration for the comment table.
 * Creates the comment table.
 */
class CreateCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$comment = new Comment();
		$tableName = $comment->getTable();
		Schema::create($tableName, function($table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('geodata_id')->unsigned();
			$table->integer('layer_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();
			$table->text('text');
			$table->tinyInteger('rating')->nullable()->unsigned();
			$table->dateTime('start')->nullable();
			$table->dateTime('end')->nullable();
			$user = new User();
			$table->foreign('user_id')->references('id')->on($user->getTable())->onDelete('SET NULL')->onChange('CASCADE');
			$geodata = new Geodata();
			$table->foreign('geodata_id')->references('id')->on($geodata->getTable())->onDelete('CASCADE')->onChange('CASCADE');
			$layer = new Layer();
			$table->foreign('layer_id')->references('id')->on($layer->getTable())->onDelete('SET NULL')->onChange('CASCADE');
		});
		// PostGIS
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN geom GEOGRAPHY(GEOMETRY,4326)");
		// Fulltext search
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN searchtext TSVECTOR");
		DB::statement("CREATE INDEX searchtext_gin_{$tableName} ON {$tableName} USING GIN(searchtext);");
		DB::statement("CREATE TRIGGER ts_searchtext_{$tableName} BEFORE INSERT OR UPDATE ON {$tableName} FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.simple', 'text')");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$comment = new Comment();
		Schema::drop($comment->getTable());
	}

}
