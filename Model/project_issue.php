<?php
class ProjectIssue extends ProjectsAppModel {
	
	var $name = 'ProjectIssue';
	var $actsAs = array('Tree');
	var $validate = array(
		'name' => array('notempty')
	); 

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'ProjectIssueParent' => array(
			'className' => 'Projects.ProjectIssue',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectIssuePriorityType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'project_issue_priority_type_id',
			'conditions' => array('ProjectIssuePriorityType.type' => 'PROJECTISSUEPRIORITY'),
			'fields' => '',
			'order' => ''
		),
		'ProjectIssueStatusType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'project_issue_status_type_id',
			'conditions' => array('ProjectIssueStatusType.type' => 'PROJECTISSUESTATUS'),
			'fields' => '',
			'order' => ''
		),
		'Contact' => array(
			'className' => 'Contacts.Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Assignee' => array(
			'className' => 'Users.User',
			'foreignKey' => 'assignee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Project' => array(
			'className' => 'Projects.Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ProjectTrackerType' => array(
			'className' => 'Enumeration',
			'foreignKey' => 'project_tracker_type_id',
			'conditions' => array('ProjectTrackerType.type' => 'PROJECTISSUETRACKER'),
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
		'TimesheetTime' => array(
			'className' => 'Timesheets.TimesheetTime',
			'foreignKey' => 'project_issue_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>