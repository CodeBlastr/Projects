<?php
class ProjectIssuesController extends ProjectsAppController {

	var $name = 'ProjectIssues';
	var $helpers = array('Cke');

	
	function index() {
		$model = $this->modelClass;
		$this->$model->recursive = 0;
		$this->set('model', $model);
		if(!empty($this->request->params['named']['assignee_id'])) {
			$this->paginate = array('conditions' => array($model.'.parent_id' => null, $model.'.assignee_id' => $this->request->params['named']['assignee_id'])); 
		} else {
			$this->paginate = array('conditions' => array($model.'.parent_id' => null)); 
		}
		$this->set('ctrl_vars', $this->paginate());
		$this->set('viewFields', array('name', 'done_ratio', 'start_date', 'due_date', 'project_id', 'contact_id', 'assignee_id', 'actions'));
		
	}


	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProjectIssue.', true));
			$this->flash(__('Invalid ProjectIssue', true), array('action'=>'index'));
		}
		# find the number of hours that have been logged for this issue
		App::import('Model', 'Timesheets.TimesheetTime');
		$this->TimesheetTime = new TimesheetTime();
		$trackedTimes = $this->TimesheetTime->find('all', array('conditions' => array('project_issue_id' => $id), 'fields' => 'hours'));
		if(!empty($trackedTimes)) {
			foreach ($trackedTimes as $trackedTime) {
				$trackedHours[] = $trackedTime['TimesheetTime']['hours'];
			}
			$trackedHoursSum = array_sum($trackedHours);
		} else {
			$trackedHoursSum = '0.00';
		}
		$this->set(compact('trackedHoursSum'));
			
		$projectIssue = $this->ProjectIssue->find('first', array(
			'contain' => array(
				'Project' => array(
					'Member',
					'Creator',
					),	
				'Assignee',						  
				'Contact',
				'ProjectTrackerType',
				'ProjectIssueStatusType', 
				'ProjectIssuePriorityType',
				),
			'conditions' => array(
				'ProjectIssue.id' => $id,
				),
			)
		);
												  
		$this->set('projectIssue', $projectIssue);
		$assignees = Set::combine($projectIssue, 'Project.Member.{n}.id', 'Project.Member.{n}.username');
		$this->set(compact('assignees'));
		
		if (!empty($this->request->params['named']['archive']) && $this->request->params['named']['archive'] == 'show') {
			$conditions['ProjectIssue.lft >='] = $projectIssue['ProjectIssue']['lft'];
			$conditions['ProjectIssue.rght <='] = $projectIssue['ProjectIssue']['rght'];
		} else {
			$conditions['ProjectIssue.archive'] = null;
			$conditions['ProjectIssue.lft >='] = $projectIssue['ProjectIssue']['lft'];
			$conditions['ProjectIssue.rght <='] = $projectIssue['ProjectIssue']['rght'];
		}
		
  		$someIssues = $this->ProjectIssue->find('threaded', array(
			'conditions' => $conditions,
			'order' => array(
				'ProjectIssue.created DESC',
				),
			'contain' => array(
				'Creator',
				'Assignee'
				)
			)
		);
		$this->set('projectTree', $someIssues);
	}

	function edit($id = null) {
		if (!empty($this->request->data)) {
			if ($this->ProjectIssue->save($this->request->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been saved', true));
				$this->redirect(array('controller' => 'projects', 'action'=>'view', $this->request->data['ProjectIssue']['project_id']));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be saved. Please, try again.', true));
				$this->redirect($this->referer());
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->ProjectIssue->read(null, $id);
		}
		$projectIssueParents = $this->ProjectIssue->ProjectIssueParent->find('list');
		$projectIssueTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list');
		$contacts = $this->ProjectIssue->Contact->find('list');
		$projects = $this->ProjectIssue->Project->find('list');
		$projectTrackerTypes = $this->ProjectIssue->ProjectTrackerType->find('list', array('conditions' => array('type' => 'PROJECTTRACKER')));
		$projectIssueStatusTypes = $this->ProjectIssue->ProjectIssueStatusType->find('list', array('conditions' => array('type' => 'PROJECTISSUESTATUS')));
		$projectIssuePriorityTypes = $this->ProjectIssue->ProjectIssuePriorityType->find('list', array('conditions' => array('type' => 'PROJECTISSUEPRIORITY')));
		$assignees = $this->ProjectIssue->Assignee->find('list');
		$this->set(compact('projects','projectTrackerTypes', 'projectIssueStatusTypes', 'projectIssuePriorityTypes', 'assignees', 'projectIssueParents', 'projectIssueTypes', 'contacts'));
	}
	
	function archive($id = null, $project_id) {
		if (!empty($id)) {
			$this->request->data['ProjectIssue']['id'] = $id;
			$this->request->data['ProjectIssue']['archive'] = 1;
			if ($this->ProjectIssue->save($this->request->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been archived', true));
				$this->redirect(array('controller' => 'projects', 'action'=>'view', $project_id));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be archived. Please, try again.', true));
			}
		}		
	}
	
	function unarchive($id = null, $project_id) {
		if (!empty($id)) {
			$this->request->data['ProjectIssue']['id'] = $id;
			$this->request->data['ProjectIssue']['archive'] = null;
			if ($this->ProjectIssue->save($this->request->data)) {
				$this->Session->setFlash(__('The ProjectIssue has been un-archived', true));
				$this->redirect(array('controller' => 'projects', 'action'=>'view', $project_id));
			} else {
				$this->Session->setFlash(__('The ProjectIssue could not be un-archived. Please, try again.', true));
			}
		}		
	}

}
?>