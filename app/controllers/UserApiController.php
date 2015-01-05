<?php

class UserApiController extends BaseApiController {
	
	protected function getSessionResponse() {
		return array(
			'session' => array(
				'session' => Session::getId(),
				'lastActivity' => self::toDate(User::getLastActivityFromSession())
			)
		);
	}

	protected function getLoginResponse() {
		$user = Auth::getUser();
		
		$json = array_merge(
			array(
				'user' => array(
					'id' => $user->id,
					'name' => $user->name,
					'email' => $user->email,
					'language' => $user->language
				)
			),
			$this->getSessionResponse()
		);
		return $this->getJsonResponse($json);
	}
	
	public function postLogin($method) {
		switch($method) {
		case 'mmm':
			$identifier = Input::get('credentials.identifier');
			$password = Input::get('credentials.password');
			$remember = Input::get('credentials.remember');
			$remember = !empty($remember);

			$field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
			$credentials = array(
				$field => $identifier,
				'password' => $password // No hashing, this is made in Auth::attempt.
			);

			if (Auth::attempt($credentials, $remember)) {
				return $this->getLoginResponse();
			}
			else {
				return $this->getForbiddenResponse();
			}
		case 'oauth':
			// TODO: Implementation
			return $this->getForbiddenResponse();
		default:
			return $this->getNotFoundResponse();
		}
	}
	
	public function getKeepalive() {
		Session::migrate(true); // TODO: Check whether this is really the best solution.
		return $this->getSessionResponse();
	}
	
	public function getLogout() {
		Auth::logout();
		return $this->getJsonResponse();
	}
	
	public function postRegister() {
		$user = new User();

		$data = Input::only('name', 'email', 'password', 'password_confirmation');
		
		$validator = Validator::make($data,
			array(
				'name' => 'required|min:3|max:60|regex:/^[^@]+$/i|unique:'.$user->getTable(),
				'email' => 'required|email|unique:'.$user->getTable(),
				'password' => 'required|confirmed|min:4|max:255',
				'password_confirmation' => 'required'
			)
		);
		
		if ($validator->fails()) {
			return $this->getConflictResponse($validator->messages());
		}
		
		$user->name = $data['name'];
		$user->email = $data['email'];
		$user->password = Hash::make($data['password']);
		if ($user->save()) {
			return $this->getJsonResponse();
		}
		else{
			return $this->getErrorResponse();
		}
	}
	
	public function postChange($what) {
		if (Auth::guest()) {
			return $this->getForbiddenResponse();
		}
		
		$user = Auth::getUser();
		$rules = array();

		switch($what) {
			case 'general':
				$table = $user->getTable();
				$rules = array(
					'name' => "sometimes|min:3|max:60|regex:/^[^@]+$/i|unique:{$table},name,{$user->id}",
					'email' => "sometimes|email|unique:{$table},email,{$user->id}",
					'language' => "sometimes|checkLanguage" 
				);
				break;
			case 'password':
				$rules = array(
					'password' => 'required|confirmed|min:4|max:255',
					'password_confirmation' => 'required'
				);
				// When using outh old_password is not needed. Validate it only when not using oauth.
				if ($user->password !== null) {
					// No need to hash old_password here as checkHash-validation is doing the hashing for us.
					$rules['old_password'] = "required|checkHash:{$user->password}";
				}
				break;
		}

		$data = Input::all();
		$validator = Validator::make($data, $rules);
		if ($validator->fails()) {
			return $this->getConflictResponse($validator->messages());
		}

		switch($what) {
			case 'general':
				// Fill an array with all valid fields that have been checked.
				$valid = array_intersect_key($validator->valid(), $rules);
				foreach($valid as $key => $value) {
					$user->$key = $value;
				}
				break;
			case 'password':
				$user->password = Hash::make($data['password']);
				break;
		}

		if ($user->save()) {
			return $this->getJsonResponse();
		}
		else {
			return $this->getConflictResponse();
		}
	}
	
	public function postCheck($what) {
		$rules = array();

		switch($what) {
			case 'email':
			case 'name':
				$user = new User();
				$rules[$what] = 'unique:'.$user->getTable();
				break;
			default: 
				return $this->getConflictResponse();
		}

		$validator = Validator::make(Input::only($what), $rules);
		if ($validator->fails()) {
			return $this->getConflictResponse();
		}
		else {
			return $this->getJsonResponse();
		}
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemindRequest() {
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::REMINDER_SENT:
				return $this->getJsonResponse();
			default: // which should be only the case Password::INVALID_USER
				return $this->getConflictResponse(array(
					'email' => Lang::get($response)
				));
		}
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postRemindReset() {
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);
			$user->save();
		});

		switch ($response)
		{
			case Password::INVALID_PASSWORD:
				return $this->getConflictResponse(array(
					'password' => Lang::get($response)
				));
			case Password::INVALID_TOKEN:
				return $this->getConflictResponse(array(
					'token' => Lang::get($response)
				));
			case Password::INVALID_USER:
				return $this->getConflictResponse(array(
					'email' => Lang::get($response)
				));
			case Password::PASSWORD_RESET:
				return $this->getJsonResponse();
		}
	}
	
}
