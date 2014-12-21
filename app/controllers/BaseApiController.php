<?php

abstract class BaseApiController extends BaseController {

	protected function getForbiddenResponse() {
		return $this->getJsonResponse(null, 403);
	}

	protected function getNotFoundResponse() {
		return $this->getJsonResponse(null, 404);
	}

	protected function getConflictResponse($data = null) {
		return $this->getJsonResponse($data, 409);
	}
	
	protected function getJsonResponse($data, $statusCode = 200) {
		return Response::json($data, $statusCode);
	}
	
}