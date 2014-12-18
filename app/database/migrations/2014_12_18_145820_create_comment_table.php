<?php

use Illuminate\Database\Migrations\Migration;

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
