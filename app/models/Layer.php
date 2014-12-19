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
        return $this->hasMany('Comment');
    }

}
?>