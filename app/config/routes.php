<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The routes file is where you define your URL structure, which is an important part of the
 * [information architecture](http://en.wikipedia.org/wiki/Information_architecture) of your
 * application. Here, you can use _routes_ to match up URL pattern strings to a set of parameters,
 * usually including a controller and action to dispatch matching requests to. For more information,
 * see the `Router` and `Route` classes.
 *
 * @see lithium\net\http\Router
 * @see lithium\net\http\Route
 */
 
use lithium\net\http\Router;
use lithium\net\http\Response;
use lithium\core\Environment;


use notes\security\Sentinel;
use app\models\Instructor;	
use notes\security\RoleManager;

/**
 * Here, we are connecting `'/'` (the base path) to controller called `'Pages'`,
 * its action called `view()`, and we pass a param to select the view file
 * to use (in this case, `/views/pages/home.html.php`; see `app\controllers\PagesController`
 * for details).
 *
 * @see app\controllers\PagesController
 */
//Router::connect('/', 'Pages::view');
Router::connect('/', 'Pages::index');


//Profile Pages

Router::connect("/professors/{:username}", array('controller'=>'Users'));
Router::connect("/professors/{:username}/{:args}", array(), array('continue'=> true,'handler'=> function($request){
	$username = $request->params['username'];
 	//echo "Request Username = " . $request->params['username'];
 	//echo "Request Controller = " . $request->params['controller'];
 	//echo "In the router handler part";

	$sen = new Sentinel();
	$results = $sen->findUsersByName($username);
		//echo var_dump($username);
	if($results && is_array($results)){
		$user = $results[0];
		$request->params['user'] = $user;
		$request->params['action'] = "listAll";
		return $request;
	}else{
		$request->params['invaliduser'] = true;
		return $request;
	}
	
})

);
//Router::connect('/professors/{:username}/{:args}', array(), array('continue' => true));

//Router::connect("/professors/{:username}/notes)", array('controller'=> 'Users','action'=>'notes')
//Router::connect('/professors/{:username}/{:args}', array(), array('continue' => true));
/*
Router::connect("/{:username}", array(), function($request) {
		$location = array('controller'=>'Users', 'action'=>'index');
		return new Response(compact('location'));
	}
);
*/



// Dashboard routing...

Router::connect('/dashboard', array('controller' => 'Dashboard', 'action'=>'index'));

Router::connect('/dashboard/{:args}', array(), array('continue' => true));

//Admin routing...
$user = Sentinel::getAuthenticatedUser();
if(($user)&&(RoleManager::IsUserInRole($user,'Administrator' ))) { 
	Router::connect('/admin', array('controller' => 'Admin', 'action'=>'index'));
	Router::connect('/admin/{:args}', array(), array('continue' => true));
}else{
	Router::connect('/admin', array('controller' => 'Accounts', 'action'=>'login'));
	Router::connect('/admin/{:args}', array('controller' => 'Accounts', 'action'=>'login'));

}




/**
 * Connect the rest of `PagesController`'s URLs. This will route URLs like `/pages/about` to
 * `PagesController`, rendering `/views/pages/about.html.php` as a static page.
 */
Router::connect('/pages/{:args}', 'Pages::view');

/**
 * Add the testing routes. These routes are only connected in non-production environments, and allow
 * browser-based access to the test suite for running unit and integration tests for the Lithium
 * core, as well as your own application and any other loaded plugins or frameworks. Browse to
 * [http://path/to/app/test](/test) to run tests.
 */
if (!Environment::is('production')) {
	Router::connect('/test/{:args}', array('controller' => 'lithium\test\Controller'));
	Router::connect('/test', array('controller' => 'lithium\test\Controller'));
}

/**
 * ### Database object routes
 *
 * The routes below are used primarily for accessing database objects, where `{:id}` corresponds to
 * the primary key of the database object, and can be accessed in the controller as
 * `$this->request->id`.
 *
 * If you're using a relational database, such as MySQL, SQLite or Postgres, where the primary key
 * is an integer, uncomment the routes below to enable URLs like `/posts/edit/1138`,
 * `/posts/view/1138.json`, etc.
 */
// Router::connect('/{:controller}/{:action}/{:id:\d+}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:\d+}');

/**
 * If you're using a document-oriented database, such as CouchDB or MongoDB, or another type of
 * database which uses 24-character hexidecimal values as primary keys, uncomment the routes below.
 */
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}');

/**
 * Finally, connect the default route. This route acts as a catch-all, intercepting requests in the
 * following forms:
 *
 * - `/foo/bar`: Routes to `FooController::bar()` with no parameters passed.
 * - `/foo/bar/param1/param2`: Routes to `FooController::bar('param1, 'param2')`.
 * - `/foo`: Routes to `FooController::index()`, since `'index'` is assumed to be the action if none
 *   is otherwise specified.
 *
 * In almost all cases, custom routes should be added above this one, since route-matching works in
 * a top-down fashion.
 */
Router::connect('/{:controller}/{:action}/{:args}');

?>