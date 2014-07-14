<?php

namespace App\Controllers;

use Coogle\Mvc\View;

/**
 * The Index Controller
 */
class IndexController extends \Coogle\Mvc\BaseController
{
	/**
	 * The index action, the only real page action in the app which returns the HTML for the page
	 */
	public function indexAction()
	{
		$colorsModel = new \Colors();
		$colors = $colorsModel->getColors();
		
		$colorList = implode(',', $colors);
		
		return View::render('index.index', compact('colors', 'colorList'));
	}
}