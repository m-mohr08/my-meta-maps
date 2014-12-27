<?php

class Geodata extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'mmm_geodata';
	
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

	public function comments() {
		return $this->hasMany('Comment', 'geodata_id');
	}

	public function layers() {
		return $this->hasMany('Layer', 'geodata_id');
	}

	public function getKeywords(){
		return explode('|', $this->keywords);
	}

	public function setKeywords(array $keywords){
		$this->keywords = implode('|', $keywords);
	}

	public function addKeyword($keyword){
		$keywords = $this->getKeywords();
		$keywords[] = $keyword;
		$this->setKeywords($keywords);
	}
	
}
?>