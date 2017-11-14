<?php 

/**
*  Corresponding Class to test OpenProject class
*
*  @author darshan
*/
class OpenProjectTest extends PHPUnit_Framework_TestCase{
	
  /**
  *  openoproject object
  */
  public function testIsThereAnySyntaxError(){
	$var = new OpenprojectAPI\OpenProject(array('apiKey'=>'apikey:3188e8aceba05379c4db2c046edb4086db0ad6c5b2c280af18e1be29425d157d'));
	$this->assertTrue(is_object($var));
	unset($var);
  }
  
  /**
  * list projects
  *
  */
  public function testListProjectApiCall(){
	$var = new OpenprojectAPI\OpenProject(array('apiKey'=>'apikey:a67868156ffea6cff291d97f0dc41f595b9759e5bf5ad3a2f4fda4c6f0b75105'));
        $this->assertTrue($var->projects()->all()->count == 4);
	unset($var);
  }
  
  /**
  * create project
  *
  */
//  public function testCreateProjectApiCall(){
//	$var = new OpenprojectAPI\OpenProject(array('apiKey'=>'apikey:a67868156ffea6cff291d97f0dc41f595b9759e5bf5ad3a2f4fda4c6f0b75105'));
//        $params = array(
//            "lockVersion" => 5,
//            "_type" => "Project",
//            "name" => "An example title"
//        );
//        print_r($var->projects()->create($params));exit;
//        $this->assertTrue($var->projects()->create($params)->count == 1);
//	unset($var);
//  }
  
}