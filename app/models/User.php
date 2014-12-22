<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_user';
	
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
	protected $hidden = array('password', 'remember_token');

	public function comments() {
		return $this->hasMany('Comment');
	}
	
	/**
	 * 
	 * @return int Last activity 
	 */
	public static function getLastActivityFromSession() {
		$bag = Session::getMetadataBag();
		if ($bag) {
			return $bag->getLastUsed();
		}
		else {
			return 0;
		}
	}

}
?>