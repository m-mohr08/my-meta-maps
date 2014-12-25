<?php

class Geodata extends Eloquent implements \GeoMetadata\Model\Metadata {

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
	protected $hidden = array();#
	
	// Attributes for the interface - not stored in DB
	private $extra = array();

	public function comments() {
		return $this->hasMany('Comment');
	}

	public function layers() {
		return $this->hasMany('Layer');
	}
	
	// Implementation of interface
	
	public function createObject() {
		return new static();
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function getServiceCode(){
		return $this->datatype;
	}

	public function setServiceCode($service){
		$this->datatype = ($this->service != null) ? $this->service->getCode() : '';
	}

	public function getLayers(){
		// TODO: Implementation
	}

	public function addLayer(\GeoMetadata\Model\Layer $layer){
		// TODO: Implementation
	}

	public function createLayer($id, $title = null, \GeoMetadata\Model\BoundingBox $bbox = null){
		// TODO: Implementation
	}

	public function removeLayer(\GeoMetadata\Model\Layer $layer){
		// TODO: Implementation
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function getBoundingBox(){
		// TODO: Implementation
	}
	
	public function setBoundingBox(\GeoMetadata\Model\BoundingBox $bbox) {
		// TODO: Implementation
	}
	
	public function createBoundingBox($west, $north, $east, $south) {
		// TODO: Implementation
	}

	public function getKeywords(){
		return explode('|', $this->keywords);
	}

	public function setKeywords(array $keywords){
		$this->keywords = implode('|', $keywords);
	}

	public function addKeyword($keyword){
		$keywords = $thi->getKeywords();
		$keywords[] = $keyword;
		$this->setKeywords($keywords);
	}

	public function getDescription(){
		return $this->abstract;
	}

	public function setDescription($description){
		$this->abstract = $description;
	}

	public function getLanguage(){
		return $this->language;
	}

	public function setLanguage($language){
		$this->language = $language;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getPublisher(){
		return $this->publisher;
	}

	public function setPublisher($publisher){
		$this->publisher = $publisher;
	}

	public function getCopyright(){
		return $this->copyright;
	}

	public function setCopyright($copyright){
		$this->copyright = $copyright;
	}

	public function getLicense() {
		return $this->license;
	}

	public function setLicense($license) {
		$this->license = $license;
	}

	public function getCreationTime(){
		return $this->creation;
	}

	public function setCreationTime(\DateTime $creation){
		$this->creation = $creation; // TODO: Convert to SQL timestamps?
	}

	public function getModifiedTime(){
		return $this->modified;
	}

	public function setModifiedTime(\DateTime $modified){
		$this->modified = $modified; // TODO: Convert to SQL timestamps?
	}
	
	public function setData($key, $value) {
		$this->extra[$key] = $value;
	}
	
	public function getData($key) {
		if (isset($this->extra[$key])) {
			return $this->extra[$key];
		}
		else {
			return null;
		}
	}
	
}
?>