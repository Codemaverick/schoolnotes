<?php  

namespace notes\utilities;
	/**
 * CodeIgniter Application ActionResult Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
use app\models\Configuration;
use \lithium\data\Connections;

 
class ApplicationSettings {
	
	public static function getConfiguration(){
		
		$em = Connections::get('default')->getEntityManager();
		$config = $em->getRepository('app\models\Configuration')->findAll();
		
		return $config[0];

	}

}
?>