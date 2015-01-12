<?php

/*
 * Copyright 2014/15 Matthias Mohr, Milan Köster
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
 * This controller handles the internal API requests related to geodata/comment tasks, like adding and retrieving comments, parsing metadata, storing permalinks for searches etc.
 * Request is always a GET or POST request with JSON based parameters. Reponse is always JSON based, too.
 */
class ExternalApiController extends BaseApiController {

	public function getSearchApi() {
		$q = Input::get('q');
		$count = Input::get('count');

		$comments = Comment::filter(compact('q'))->take($count)->get();
		$data = array(
			'resource' => Config::get('app.url') . $_SERVER['REQUEST_URI'],
			'comments' => array()
		);
		foreach ($comments as $comment) {
			$dataComment = array(
				'id' => Config::get('app.url') . '/geodata/' . $comment->geodata_id . '/comment/' . $comment->id,
				'text' => $comment->text,
				'itemUnderReview' => $comment->url
			);
			if (!empty($comment->rating)) {
				$dataComment['rating'] = $comment->rating;
			}
			$data['comments'][] = $dataComment;
		}
		return $this->getJsonResponse($data);
	}

}
