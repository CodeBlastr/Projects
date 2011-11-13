<?php
class Project extends ProjectsAppModel {

	var $name = 'Project';
	var $displayField = 'name';
	var $validate = array(
		'name' => array('notempty')
		); 
	var $actsAs = array('Users.Usable' => array('defaultRole' => 'member'));
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ProjectStatusType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'project_status_type_id',
			'conditions' => array('ProjectStatusType.type' => 'PROJECTSTATUS'),
			'fields' => '',
			'order' => 'weight'
		),
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Manager' => array(
			'className' => 'Users.User',
			'foreignKey' => 'manager_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Users.User',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Users.User',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ProjectIssue' => array(
			'className' => 'Projects.ProjectIssue',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => array('parent_id' => NULL),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ProjectsMember' => array(
			'className' => 'Projects.ProjectsMember',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' =>'',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserGroup' => array(
			'className' => 'Users.UserGroup',
			'foreignKey' => '',
			'dependent' => false,
			'conditions' => array('UserGroup.model' => 'Project'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Used' => array(
			'className' => 'Users.Used',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array('Used.model' => 'Project'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Message' => array(
			'className' => 'Messages.Message',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array('Message.model' => 'Project'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Task' => array(
			'className' => 'Tasks.Task',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array('Task.model' => 'Project'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'TimesheetTime' => array(
			'className' => 'Timesheets.TimesheetTime',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Invoice' => array(
			'className' => 'Invoices.Invoice',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	var $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'Users.User',
			'joinTable' => 'used',
			'foreignKey' => 'foreign_key',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Member' => array(
			'className' => 'Users.User',
			'joinTable' => 'projects_members',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Watcher' => array(
			'className' => 'Users.User',
			'joinTable' => 'projects_watchers',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'user_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Wiki' => array(
			'className' => 'Wikis.Wiki',
			'joinTable' => 'projects_wikis',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'wiki_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
        'Category' => array(
            'className' => 'Categories.Category',
       		'joinTable' => 'categorizeds',
            'foreignKey' => 'foreign_key',
            'associationForeignKey' => 'category_id',
    		'conditions' => 'Categorized.model = "Project"',
    		// 'unique' => true,
        ),
	);
	
	function __construct($id = false, $table = null, $ds = null) {
    	parent::__construct($id, $table, $ds);
	    $this->virtualFields['displayName'] = sprintf('CONCAT(%s.name, " <small>", Contact.name, "</small>")', $this->alias);
	    #$this->virtualFields['displayName'] = sprintf('CONCAT(%s.name)', $this->alias);
	    $this->virtualFields['displayDescription'] = $this->alias.'.quick_note';
		$this->displayField = 'displayName';
		$this->order = array("{$this->alias}.name");		
    }
	
	function beforeFind($queryData) {
		$this->listSearch = !empty($queryData['list']) ? true : null;
		return $queryData;
	}
	
	function afterFind($results, $primary) {		
		if (!empty($this->listSearch)) : 
			$i = 0;
			foreach ($results as $result) : 
				$results[$i]['Project']['displayName'] = strip_tags(str_replace('<small>', ' : ', $result['Project']['displayName']));
				$i++;
			endforeach;
		endif;
		return $results;
	}

	function find($type = null, $params = array()) {
		$params = Set::merge(array('contain' => array('Contact.name')), $params);
		return parent::find($type, $params);
	}
	
	/**
	 * @todo		$data['Project']['manager_id'] should be $data['Project'][0]['manager_id'] if we're going to use saveAll
	 */
	function add($data) {
		$data = $this->cleanInputData($data);
		if ($this->saveAll($data, array('atomic' => false))){
			return true;
		} else {
			throw new Exception('Project save failed.');
		}
	}
	
	
	/** 
	 * Take the input data and parse it for actual saving
	 */
	function cleanInputData($data) {		
		return $data;
	}
	
	function findContactsWithProjects($type = 'list', $params = null) {
		$projects = $this->find('all', array(
			'conditions' => array(
				'Project.contact_id is NOT NULL',
				),
			'contain' => array(
				'Contact' => array(
					'fields' => array(
						'Contact.id',
						'Contact.name',
						),
					)
				)
			));
		debug($projects);
		$contactIds = Set::extract('/Contact/id', $projects);
		$params['conditions']['Contact.id'] = array_unique($contactIds);
		return $this->Contact->find($type, $params);
	}

}
?>