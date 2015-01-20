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
 * Implementation of the external API that is implementing a basic OGC Date&Time Search Extension.
 */
class ExternalApiController extends BaseApiController {

	/**
	 * Implementation for the search API that is listening for the query parameters q and count.
	 * 
	 * @see https://github.com/m-mohr/my-meta-maps/wiki/External-API
	 * @return Response
	 */
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
				'id' => $comment->createPermalink(),
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
