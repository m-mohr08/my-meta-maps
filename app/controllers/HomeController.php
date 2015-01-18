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

	public function getFrontpage($language = null) {
		if (Language::valid($language) && !Language::is($language)) {
			Language::change($language);
		}
		return View::make('frontpage');
	}

	public function getSearch($hash) {
		return Redirect::to('/' . Language::current() . '#/search/' . $hash);
	}

	public function getGeodata($geodata) {
		return Redirect::to('/' . Language::current() . '#/geodata/' . $geodata)->with('geodata', '\d+');
	}

	public function getComment($geodata, $comment) {
		return Redirect::to('/' . Language::current() . '#/geodata/' . $geodata . '/comment/' . $comment)->with('geodata', '\d+')->with('comment', '\d+');
	}

	public function oauth(\Opauth $opauth) {
		$response = unserialize(base64_decode(Input::get('opauth')));

		$error = false;
		if (array_key_exists('error', $response) || empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])) {
			Log::debug('Opauth: Invalid response');
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
				$user = new User();

				$validator = Validator::make($response['auth']['info'],
					array(
						'name' => 'required|min:3|max:60|regex:/^[^@]+$/i|unique:'.$user->getTable(),
						'email' => 'required|email|unique:'.$user->getTable()
					)
				);
				if ($validator->fails()) {
					Log::debug('Opauth: User data does not fit our requirements');
					$error = true;
				}
				else {
					$user->name = $response['auth']['info']['name'];
					$user->email = $response['auth']['info']['email'];
					$user->oauth = $nsUid;
					if (!$user->save()) {
						Log::debug('OpAuth: Could not register user');
						$user = null;
						$error = true;
					}
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
