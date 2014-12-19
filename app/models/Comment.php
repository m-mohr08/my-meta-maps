<?php

class Comment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_comment';
	
	/**
	 * Tell the ORM to use timestamp fields or not. 
	 * 
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public function user() {
		return $this->belongsTo('User');
	}

	public function layer() {
		return $this->belongsTo('Layer');
	}
	
    public function geodata() {
        return $this->belongsTo('Geodata');
    }

}
?>