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
 * Abstract base controller for internal API implementing controllers.
 * Holds some common methods to work with the client server protocol.
 */
abstract class BaseApiController extends BaseController {

	protected function toDate($value = null) {
		$format = 'c';
		// Current date/time
		if ($value === null) {
			return date($format);
		}
		// PHP DateTime object, applies also for PgSQL timestamps via Eloquent which uses Carbon and DateTime.
		// Cheking DateTime for PHP < 5.5, DateTimeInterface for PHP >= 5.5
		else if (is_a($value, "DateTime") || is_a($value, "DateTimeInterface")) {
			return $value->format($format);
		}
		// Unix timestamp
		else if (preg_match('~^\d+$~', $value)) {
			return date($format, $value);
		}
		else {
			App::debug('Incorrect date/time value given for BaseApiController::toDate()');
			return null;
		}
	}
	
	protected function getForbiddenResponse() {
		return $this->getJsonResponse(null, 403);
	}

	protected function getNotFoundResponse() {
		return $this->getJsonResponse(null, 404);
	}

	protected function getConflictResponse($data = null) {
		if ($data instanceof MessageBag) {
			$data = array_map(
				function ($value) {
					return implode("\r\n", $value);
				},
				$data->toArray()
			);
		}
		return $this->getJsonResponse($data, 409);
	}
	
	protected function getJsonResponse($data = null, $statusCode = 200) {
		return Response::json($data, $statusCode);
	}
	
}