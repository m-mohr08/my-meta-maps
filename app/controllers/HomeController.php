<?php
/*
 * Copyright 2014/15 Matthias Mohr
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Controller that handles the externally accessible routes and renders the actual page to the visitor.
 */
class HomeController extends BaseController {

	/**
	 * Handles the default GET requests and returns our client side Single Page Application.
	 * 
	 * @param string $language Language code that is used to translate the page.
	 * @return Response
	 */
	public function getFrontpage($language = null) {
		if (Language::valid($language) && !Language::is($language)) {
			Language::change($language);
		}
		return View::make('frontpage');
	}

	/**
	 * Redirects a GET request for the search permalinks to the SPA.
	 * 
	 * @param string $hash Hash code of the permalink
	 * @return Response
	 */
	public function getSearch($hash) {
		return Redirect::to('/' . Language::current() . '#/search/' . $hash);
	}

	/**
	 * Redirects a GET request for a geodata set to the corresponding page in the SPA.
	 * 
	 * @param int $geodata ID of the Geodata
	 * @return Response
	 */
	public function getGeodata($geodata) {
		return Redirect::to('/' . Language::current() . '#/geodata/' . $geodata)->with('geodata', '\d+');
	}

	/**
	 * Redirects a GET request for a comment to the corresponding page in the SPA.
	 * 
	 * @param int $geodata ID of the Geodata
	 * @param int $comment ID of the Comment
	 * @return Response
	 */
	public function getComment($geodata, $comment) {
		return Redirect::to('/' . Language::current() . '#/geodata/' . $geodata . '/comment/' . $comment)->with('geodata', '\d+')->with('comment', '\d+');
	}

	/**
	 * A simple JavaScript cross domain proxy.
	 * 
	 * @return Response
	 */
	public function getProxy() {
		$url = Input::get('url');
		$net = new \GeoMetadata\GmNet();
		return Response::make($net->get($url));
	}
	
	/**
	 * Handles the OAuth authentification process.
	 * 
	 * The response from the external authentification provider is handled and might lead to a registration and/or a login.
	 * 
	 * Redirects the user to the SPA and calls the suitable action.
	 * 
	 * @param \Opauth $opauth Opauth instance
	 * @return Response
	 */
	public function oauth(\Opauth $opauth) {
		session_start();
		$response = $_SESSION['opauth'];
		unset($_SESSION['opauth']);

		$error = false;
		if (array_key_exists('error', $response) || empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])) {
			Log::debug('Opauth: Invalid response | ' . json_encode($response));
			$error = true;
		}
		elseif (!$opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason)) {
			Log::debug('Opauth: '. $reason);
			$error = true;
		}
		
		if (!$error) {
			$nsUid = $response['auth']['provider'].':'.$response['auth']['uid'];
			$user = User::where('oauth', $nsUid)->first();
			if ($user === null) {
				// Register
				$info = $response['auth']['info'];
				$user = new User();
				$user->name = $info['name'];
				$user->email = empty($info['email']) ? null : $info['email'];
				$user->oauth = $nsUid;

				$nameValidator = Validator::make($info, array('name' => 'required|min:3|max:60|regex:/^[^@]+$/i|unique:'.$user->getTable()));
				if ($nameValidator->fails()) {
					// The specified name is not acceptable, build an acceptable random name
					$user->name = str_replace('@', '', substr($user->name, 0, 55)) . ' ' . mt_rand(2, 99999);
				}

				// We don't require an email for now as the OpAuth strategies are badly implemented in terms of providing an email
				$mailvalidator = Validator::make($info, array('email' => 'email|unique:'.$user->getTable()));
				if ($mailvalidator->fails()) {
					// The specified email is not acceptable, simply save none.
					$user->email = null;
				}

				// Finally save the new user
				if (!$user->save()) {
					Log::debug('OpAuth: Could not register user');
					$user = null;
					$error = true;
				}
			}

			// Login
			if ($user !== null) {
				Auth::login($user);
			}
		}

		if ($error) {
			return Redirect::to('/' . Language::current() . '#/oauth/failed');
		}
		else {
			return Redirect::to('/' . Language::current());
		}
	}

}
