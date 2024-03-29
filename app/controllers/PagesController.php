<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

/**
 * This controller is used for serving static pages by name, which are located in the `/views/pages`
 * folder.
 *
 * A Lithium application's default routing provides for automatically routing and rendering
 * static pages using this controller. The default route (`/`) will render the `home` template, as
 * specified in the `view()` action.
 *
 * Additionally, any other static templates in `/views/pages` can be called by name in the URL. For
 * example, browsing to `/pages/about` will render `/views/pages/about.html.php`, if it exists.
 *
 * Templates can be nested within directories as well, which will automatically be accounted for.
 * For example, browsing to `/pages/about/company` will render
 * `/views/pages/about/company.html.php`.
 */
 
use \lithium\data\Connections;

class PagesController extends \lithium\action\Controller {
	
	public function ___construct(array $config = array()){
		parent::__construct($config);
		
	}
	
	public function index(){
		
		//"As default controller, function is called statically";
		
		$this->em = Connections::get('default')->getEntityManager();
		$this->dbContext = $this->em->getRepository('app\models\Course');
		$this->insContext = $this->em->getRepository('app\models\Instructor');
		$professors = $this->insContext->findAll();
		$courses = $this->dbContext->findAll();
		
		//print_r($_COOKIE);
		
		$data = array('instructors'=>$professors, 'courses'=>$courses);
		$this->set($data);
		
	}
	
	public function view() {
		$path = func_get_args() ?: array('home');
		return $this->render(array('template' => join('/', $path)));
	}
}

?>