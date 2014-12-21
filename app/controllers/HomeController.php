<?php

class HomeController extends BaseController {

	public function showFrontpage()
	{
		return View::make('frontpage');
	}
	
	public function showSearch($hash)
	{
		return View::make('frontpage');
	}
	
	public function showGeodata($geodata)
	{
		return View::make('frontpage');
	}
	
	public function showComment($geodata, $comment)
	{
		return View::make('frontpage');
	}

}
