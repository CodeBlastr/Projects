<?php
App::uses('Project', 'Projects.Model');

/**
 * Project Test Case
 *
 */
class ProjectTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
        'app.Condition', // dependency
        'plugin.Projects.Project',
        'plugin.Users.Used', // dependency
        'plugin.Users.User', // dependency
        'plugin.Contacts.Contact', // dependency
        'plugin.Activities.Activity', // NOT dependency
        );

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Project = ClassRegistry::init('Projects.Project');
		$this->Activity = ClassRegistry::init('Activities.Activity');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contact);
		unset($this->Activity);

		parent::tearDown();
	}
    
    
	public function testAdd() {
        $this->Project->create();
        $result = $this->Project->save(array('Project' => array('name' => 'Lorem Project')));
        $this->assertTrue(!empty($result)); // make sure the save worked
    }

/**
 * test Add method
 *
 * @return void
 */
	public function testEdit() {
        $this->Project->create();
        $result = $this->Project->save(array('Project' => array('name' => 'Lorem Project')));
        $id = $this->Project->id;
        $data = array('Project' => array('id' => $id, 'name' => 'Lorem Edit Project'));
        $this->Project->create();
        $result = $this->Project->save($data);
        $this->assertEqual($result['Project']['name'], $data['Project']['name']); // was the project edited? 
        
        $result = $this->Activity->find('first', array('conditions' => array('Activity.model' => 'Project', 'Activity.foreign_key' => $this->Project->id)));
        $this->assertEqual($result['Activity']['action_description'], 'project touched'); // was the project edit logged?
	}
	
	public function testActivities() {
		//debug($this->Project->activities());
		//break;
	}
}
