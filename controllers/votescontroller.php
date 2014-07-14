<?php

namespace App\Controllers;

use Coogle\Mvc\Json\Response;

/**
 * The Votes controller
 */
class VotesController extends \Coogle\Mvc\BaseController
{
	/**
	 * The votes action returns a JSON response based on the GET
	 * variable 'colors' as to how many votes that color has.
	 */
	public function votesAction()
	{
		$color = $this->getRequest()->input()->get('color', null);
		
		if(is_null($color)) {
			return new Response(null);
		}
		
		$votesModel = new \Votes();
		$votes = $votesModel->getVotesForColor($color);
		
		return new Response($votes);
	}
}