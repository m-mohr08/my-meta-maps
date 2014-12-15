<?php

class Session extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Session';
	
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

}
?>