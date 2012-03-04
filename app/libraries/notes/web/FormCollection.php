<?php 
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
 
namespace notes\web;

use \ReflectionClass;
use \ReflectionProperty;


class FormCollection {
	
	private $source;
	private $items;
	
	public function __construct($input){
		return $this->source = $input;
	}
	
	public function getItems(){
		return $this->source;
	}
	
	public function getItem($key){
		return array_key_exists($key, $this->source) ? $this->source[$key] : null;
	}
	
	public function createObject($type){
		$path = $this->source;
		
		if($this->source == null) return null;
		
		$klass = "app\models\\" . $type;
		$obj = new $klass();
		
		$props = $this->getClassProperties($obj);
		
		foreach($props as $item){
			
			$p = $item->getName(); //echo "Property Name: " . $item->getName() . "<br/>";
			if(isset($path[$p])){
				$item->setAccessible(true);
				$item->setValue($obj, $path[$p]);
			}
			
		}
		
		return $obj;
	}
	
	public function updateObject($type, $obj){
		$path = $this->source;
		
		if($this->source == null) return $obj;
	
		$props = $this->getClassProperties($obj);
		
		foreach($props as $item){
			
			$p = $item->getName();
			if(isset($path[$p])){
				$item->setAccessible(true);
				$item->setValue($obj, $path[$p]);
			}
			
		}
		
		return $obj;
	}
	
	function getClassProperties($type){
		$reflect = new \ReflectionClass($type);
		$props   = $reflect->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);
		//base case
		if($reflect->getParentClass() == null){
			//echo "no parent class <br/>: ". count($props);
			$p = array(); //just in case class has no properties;
			return count($props) > 0 ? $props : $p;
		}else{
			//echo "parent class <br/>: ". count($props);
			$typeName = $reflect->getParentClass()->getName();
			return array_merge($props, $this->getClassProperties(new $typeName()));
		}
	}
	
	/**
	   * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
	   * @param    string   $str    String in camel case format
	   * @return    string            $str Translated into underscore format
	   */
	  function from_camel_case($str) {
		$str[0] = strtolower($str[0]);
		$func = create_function('$c', 'return "_" . strtolower($c[1]);');
		return preg_replace_callback('/([A-Z])/', $func, $str);
	  }
	 
	  /**
	   * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
	   * @param    string   $str                     String in underscore format
	   * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
	   * @return   string                              $str translated into camel caps
	   */
	  function to_camel_case($str, $capitalise_first_char = false) {
		if($capitalise_first_char) {
		  $str[0] = strtoupper($str[0]);
		}
		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $str);
	  }
	  
	  
	  
	  function camelCase($subject, $delimiters=' _-', $lcfirst=true)
	  {
		if ( ! is_string($subject))
		{
		  throw new Exception("Subject must be of type string");
		}
		$subject = preg_replace('/[\s]+/', ' ', $subject);
	 
		$subject = preg_split("/[$delimiters]/", $subject, -1, PREG_SPLIT_NO_EMPTY);
	 
		foreach ($subject as $key => &$word)
		{
		  $word = preg_replace('/[[:punct:]]/', '', $word);
	 
		  if (preg_match('/[A-Z]+$/', $word)) $word = ucfirst($word);
	 
		  else $word = ucfirst( strtolower($word) );
		}
		$subject = implode('', $subject);
	 
		if ($lcfirst)
		{
		  return function_exists('lcfirst') ? lcfirst($subject)
		  :
		  strtolower($subject[0]).substr($subject,1);
		}
		return $subject;
	  }
	
	
}



?>