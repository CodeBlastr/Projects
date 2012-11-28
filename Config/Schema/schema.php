<?php 
class ProjectsSchema extends CakeSchema {

	public $renames = array();

	public function __construct($options = array()) {
		parent::__construct();
	}

	public function before($event = array()) {
		App::uses('UpdateSchema', 'Model'); 
		$this->UpdateSchema = new UpdateSchema;
		$before = $this->UpdateSchema->before($event);
		return $before;
	}

	public function after($event = array()) {
		$this->UpdateSchema->rename($event, $this->renames);
		$this->UpdateSchema->after($event);
	}

	public $project_issues = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'comment' => 'used for threading issues'),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'project_issue_priority_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'project_issue_status_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'start_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'due_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'estimated_hours' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'done_ratio' => array('type' => 'float', 'null' => false, 'default' => '0'),
		'private' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'archive' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'contact_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'assignee_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'comment' => 'user id assigned to the task'),
		'project_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'project_tracker_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'priority_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'creator_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'modifier_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $projects = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'project_status_type_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'quick_note' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'estimated_hours' => array('type' => 'float', 'null' => true, 'default' => NULL, 'length' => '10,2'),
		'public' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'is_archived' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'contact_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'who the project was created for', 'charset' => 'utf8'),
		'manager_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'creator_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifier_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
