<?php

class Layer extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_layer';
	
	/**
	 * Tell the ORM to use timestamp fields or not. 
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    public function geodata() {
        return $this->belongsTo('Geodata');
    }

    public function comments() {
        return $this->hasMany('Comment', 'layer_id');
    }
	
	public function getBboxAttribute($value) {
		if (!empty($value)) {
			// TODO: THIS SHOULD BE AVOIDED IN ANY CASE! Need to change this...
			$result = DB::selectOne("SELECT ST_AsText('{$value}') AS bbox");
			return $result->bbox;
		}
		else {
			return null;
		}
	}

}
?>