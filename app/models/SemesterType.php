<?php
 
namespace app\models;
 
/**
 * @Entity
 */

class SemesterType
{
	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id; 
		
	/**
	 * @Column(type="string", nullable=true)
	 */
	private $type;
	 
		 
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }
    public function setType($type) { $this->type = $type; }
    public function getType() { return $this->type; }
    
}
