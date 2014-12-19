<?php

use Illuminate\Database\Migrations\Migration;

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
			$table->text('abstract');
			$table->text('subject');
			$table->text('publisher');
			$table->text('author');
			$table->text('copyright');
			$table->datetime('creation')->nullable();
			$table->datetime('modified')->nullable();
			$table->string('language', 2)->nullable();
		});
		// PostGIS
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN bbox GEOGRAPHY(POLYGON,4326)");
		// Fulltext search
		DB::statement("ALTER TABLE {$tableName} ADD COLUMN searchtext TSVECTOR");
		DB::statement("CREATE INDEX searchtext_gin_{$tableName} ON {$tableName} USING GIN(searchtext)");
		DB::statement("CREATE TRIGGER ts_searchtext_{$tableName} BEFORE INSERT OR UPDATE ON {$tableName} FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.simple', 'title', 'abstract', 'subject', 'publisher', 'author', 'copyright')");
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
