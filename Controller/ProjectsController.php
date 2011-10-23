<?php
class ProjectsController extends ProjectsAppController {

	var $name = 'Projects';
	var $paginate = array('limit' => 10, 'order' => array('Project.created' => 'desc'));
	var $components = array(
		'Comments.Comments' => array(
			'userModelClass' => 'Users.User',
			'actionNames' => array('message', 'messages', 'tasks', 'task')
			)
		);
	var $allowedActions = array('desktop_index');
	
	function beforeFilter() {
		parent::beforeFilter();
		$this->passedArgs['comment_view_type'] = 'threaded';
	}

	/**
	 * Show only projects you have access to on the index.
	 * Use admin_dashboard() for all projects
	 */
	function index() {
		$this->paginate = array(
			'fields' => array(
				'id',
				'displayName',
				'star',
				'modified',
				),
			'order' => array(
				'Project.modified'
				),
			'limit' => 25,
			);
		$this->paginate['conditions']['Project.is_archived'] = !empty($this->request->params['named']['archived']) ? 1 : 0;
		$this->set('projects', $this->paginate());
		$this->set('displayName', 'displayName');
		$this->set('displayDescription', ''); 
		$this->set('indexClass', ''); 
		$this->set('pageActions', array(
			array(
				'linkText' => 'Create',
				'linkUrl' => array(
					'action' => 'add',
					),
				),
			array(
				'linkText' => 'Archived',
				'linkUrl' => array(
					'action' => 'index',
					'archived' => 1,
					),
				),
			));
	}

	function view($id = null) {
		$this->_testValidity($id);
		
		$project = $this->Project->find('first', array(
			'contain' => array(
				'ProjectIssue',
				),
			'conditions' => array(
				'Project.id' => $id
				)
			)
		);
		
		if (!empty($project)) {
			# find the number of hours that have been logged for this issue
			$trackedTimes = $this->Project->TimesheetTime->find('all', array(
				'conditions' => array(
					'TimesheetTime.project_id' => $id
					),
				'fields' => 'hours',
				));
			if(!empty($trackedTimes)) : 
				foreach ($trackedTimes as $trackedTime) :
					$trackedHours[] = $trackedTime['TimesheetTime']['hours'];
				endforeach;
			endif;
			
			# average out the done ratio to get the project done ratio
			foreach ($project['ProjectIssue'] as $projectIssue) {
				$doneRatios[] = $projectIssue['done_ratio'];
			}
			
			$trackedHoursSum = !empty($trackedHours) ? array_sum($trackedHours) : '0.00';
			$percentComplete = !empty($doneRatios) ? number_format(array_sum($doneRatios) / count($doneRatios), 2, '.', ',') : 0;
			
			$this->set(compact('project', 'trackedHoursSum', 'percentComplete'));
		} else {
			$this->flash(__('Invalid Project.', true), array('action'=>'index'));
		}
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->set('title_for_layout',  strip_tags($project['Project']['displayName']));
		$this->set('tabsElement', '/projects');
	}

	 
	function add($id = null) {
		if (!empty($this->request->data)) {
			try {
				$result = $this->Project->add($this->request->data);
				$this->redirect(array('action' => 'view', $this->Project->id));
			} catch(Exception $e) {
				$result = $e->getMessage();
			}
		}
		
		$this->request->data['Project']['contact_id'] = !empty($this->request->params['named']['contact']) ? $this->request->params['named']['contact'] : null;
		$contacts = $this->Project->Contact->findCompaniesWithRegisteredUsers('list');
		$userGroups = $this->Project->UserGroup->findRelated('Project', 'list');
		$this->set(compact('contacts','userGroups'));	
		$this->set('page_title_for_layout', 'Create a new project');
		$this->set('title_for_layout', 'New project form');
	}
	
	 
	function edit($id = null) {
		if (!empty($this->request->data)) {
			try {
				$result = $this->Project->add($this->request->data);
				$this->redirect(array('action' => 'view', $this->Project->id));
			} catch(Exception $e) {
				$result = $e->getMessage();
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Project->read(null, $id);
		}
		
		$contacts = $this->Project->Contact->findCompaniesWithRegisteredUsers('list');
		$userGroups = $this->Project->UserGroup->findRelated('Project', 'list');
		$this->set(compact('contacts','userGroups'));	
		$this->set('page_title_for_layout', 'Edit '.$this->request->data['Project']['displayName']);
		$this->set('title_for_layout', 'New project form');
	}
	
	
	
	function delete($id = null) {
		$this->__delete('Project', $id);
	}	
		
	
	function archive($id = null) {
		if (!empty($id)) {
			$this->request->data['Project']['id'] = $id;
			$this->request->data['Project']['is_archived'] = 1;
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The Project has been archived', true));
				$this->redirect(array('controller' => 'projects', 'action'=>'index'), 'success');
			} else {
				$this->Session->setFlash(__('The Project could not be archived. Please, try again.', true), 'error');
			}
		}		
	}
	
	
	function unarchive($id = null) {
		if (!empty($id)) {
			$this->request->data['Project']['id'] = $id;
			$this->request->data['Project']['is_archived'] = 0;
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The Project has been un-archived', true));
				$this->redirect(array('controller' => 'projects', 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Project could not be un-archived. Please, try again.', true));
			}
		}		
	}	
	
	
	# Desktop App Function
	function desktop_index($userId = null){
		# find issues assigned to this user.
		$userissues = $this->Project->Task->find('all', array(
			'conditions' => array(
				'Task.parent_id is not null',
				'Task.model' => 'Project',
				'Task.is_completed' => 0,
				'Task.assignee_id' => $userId,
				),
			'fields' => array(
				'foreign_key',
				),
			));
		foreach ($userissues as $issue) {
			$issues[] = $issue['Task']['foreign_key'];
		}
		# find only the projects that have issues assigned or are managed by this user
		$this->str = '<option value="">-- Select --</option>';
		$projects = $this->Project->find('all', array(
			'conditions' => array(
				'Project.is_archived' => 0,
				'Project.id' => $issues,
				),
			'contain' => array(
				'Contact',
				),
			'nocheck' => $userId,
			));
		for($i= 0 ;$i<sizeof($projects);$i++){
			$this->str .= "<option value=".$projects[$i]['Project']['id'].">".$projects[$i]['Project']['displayName']."</option>";
		}
		$this->set('data', $this->str);  
	}
	
	function ajax_edit(){ 
		$this->__ajax_edit();
	} 

	function _testValidity($id = null) {
		if (!$id) :
			$this->Session->setFlash(__('Invalid Project', true));
			$this->redirect(array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index'), 'error');
		endif;
	}
	
	

	/**
	 * Show the people related to this project.
	 * @todo 	Make this so that it renders using an element from the contacts plugin
	 */
	function people($projectId = null) {
		$this->_testValidity($projectId);
		$this->paginate = array(
			'conditions' => array(
				'Used.model' => 'Project',
				'Used.foreign_key' => $projectId,
				),
			'fields' => array(
				'id',
				'role',
				'user_id',
				),
			'contain' => array(
				'User' => array(
					'fields' => array(
						'full_name',
						),
					),
				),
			'order' => array(
				'User.full_name'
				),
			'limit' => 10,
			);
		$project = $this->Project->find('first', array(
			'conditions' => array('Project.id' =>  $projectId), 'contain' => 'Contact'));
		$this->set('project', $project); 
		$this->set('people', $this->paginate('Used'));
		$this->set('users', $this->Project->Used->User->find('list'));
		$this->set('modelName', 'User');
		$this->set('pluginName', 'users');
		$this->set('displayName', 'full_name');
		$this->set('displayDescription', ''); 
		$this->set('showGallery', true);
		$this->set('galleryModel', array('name' => 'User', 'alias' => 'Used'));
		$this->set('galleryForeignKey', 'user_id');
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->set('tabsElement', '/projects');
	}
	
	
	/**
	 * Remove users from a project
	 */
	function used() {
		try {
			$this->Project->addUsedUser($this->request->data);
			$this->Session->setFlash(__('User Added', true));
			$this->redirect($this->referer());
		} catch(Exception $e) {
			$this->Session->setFlash(__($e->getMessage(), true));
			$this->redirect($this->referer());
		}
	 }
	
	
	/**
	 * Remove users from a project
	 */
	function unuse($userId = null, $foreignKey = null) {
		if ($this->Project->removeUsedUser($userId, $foreignKey)) :
			$this->Session->setFlash(__('User Removed', true));
			$this->redirect($this->referer());
		else : 
			$this->Session->setFlash(__('ERROR : User remove failed.', true));
			$this->redirect($this->referer());
		endif;
	 }
	
	
	/**
	 * Show the messages related to this project.
	 * @todo 	Make this so that it renders using an element from the messages plugin
	 */
	function messages($projectId = null) {
		$this->_testValidity($projectId);
		$this->paginate = array(
			'conditions' => array(
				'Message.model' => 'Project',
				'Message.foreign_key' => $projectId,
				),
			'fields' => array(
				'id',
				'title',
				'created',
				'body',
				),
			'contain' => array(
				'Sender' => array(
					'fields' => array(
						'full_name',
						),
					),
				),
			'order' => array(
				'Message.created DESC'
				),
			'limit' => 10,
			);
		$project = $this->Project->find('first', array('conditions' => array('Project.id' =>  $projectId), 'contain' => 'Contact'));
		$this->set('project', $project); 
		# the commented text in the next line is an example of how to remove the current logged in user
		# from the list of users returned in this function from the usable behavior
		$this->set('users', $this->Project->findUsedUsers($projectId, 'list'/*, array('conditions' => array('User.id !=' => $this->Session->read('Auth.User.id')))*/));
		$this->request->data['Message']['foreign_key'] = !empty($projectId) ? $projectId : null;
		$this->set('messages', $this->paginate('Message'));
		$this->set('modelName', 'Message');
		$this->set('pluginName', 'messages');
		$this->set('link', array('pluginName' => 'projects', 'controllerName' => 'projects', 'actionName' => 'message'));
		$this->set('displayName', 'title');
		$this->set('displayDescription', 'body'); 
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->set('tabsElement', '/projects');
		if (!empty($messages) && isset($this->request->params['requested'])) {
        	return 'someting'.$messages;
        } else {
			return false;
		}
	}
	
	
	
	function message($messageId = null) {
		if (!$messageId) {
			$this->Session->setFlash(__('Invalid message', true));
			$this->redirect(array('action' => 'index'));
		}
		
		#$this->Project->commentAdd(0, $options = array('modelId' => $messageId, 'modelName' => 'Message'));
		$this->Project->Message->recursive = 1;
		$message = $this->Project->Message->read(null, $messageId);
		
		/* This is having too many problems with the usable behavior with no use right now. Not to mention that it doesn't work on a per user basis so, its pretty much worthless as is.
		if (!empty($message) && $message['Message']['is_read'] == 0) : 
			$message['Message']['is_read'] = 1;
			if ($this->Project->Message->save($message)) :
			else : 
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
				$this->redirect(array('action' => 'index'));
			endif;
		endif; */
		
		$this->set(compact('message'));
		$project = $this->Project->find('first', array(
			'conditions' => array('Project.id' => $message['Message']['foreign_key']), 'contain' => 'Contact'));
		$this->set('project', $project); 
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->Project->Message->fullName = 'Messages.Message';
		$comments->viewVariable = 'message';
		$this->set('boxes', $this->Project->Message->boxes());
		$this->set('tabsElement', '/projects');
	}
	
	
	/**
	 * Show the messages related to this project.
	 * @todo 	Make this so that it renders using an element from the tasks plugin
	 */
	function tasks($projectId = null) {
		$this->_testValidity($projectId);
		$this->paginate = array(
			'conditions' => array(
				'Task.model' => 'Project',
				'Task.foreign_key' => $projectId,
				'Task.parent_id' => null,
				),
			'fields' => array(
				'id',
				'name',
				'is_completed',
				'created',
				),
			'contain' => array(
				'Assignee' => array(
					'fields' => array(
						'full_name',
						),
					),
				),
			'order' => array(
				'Task.created DESC'
				),
			'limit' => 10,
			);
		$project = $this->Project->find('first', array(
			'conditions' => array('Project.id' =>  $projectId), 'contain' => 'Contact'));
		$this->set('project', $project); 
		$this->request->data['Task']['foreign_key'] = !empty($projectId) ? $projectId : null;
		$this->set('tasks', $this->paginate('Task'));
		$this->set('modelName', 'Task');
		$this->set('pluginName', 'tasks');
		$this->set('link', array('pluginName' => 'projects', 'controllerName' => 'projects', 'actionName' => 'task'));
		$this->set('displayName', 'name');
		$this->set('displayDescription', ''); 
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->set('tabsElement', '/projects');
	}
	
	
	/**
	 * Show the messages related to this project.
	 * @todo 	Make this so that it renders using an element from the tasks plugin
	 */
	function task($taskId = null) {		
		$this->_testValidity($taskId);
		
		$task = $this->Project->Task->find('first', array(
			'conditions' => array(
				'Task.id' => $taskId,
				),
			));
		
		$this->set('task', $task);
		$project = $this->Project->find('first', array(
			'conditions' => array('Project.id' => $task['Task']['foreign_key']), 'contain' => 'Contact'));
		$this->set('project', $project); 
		$associations =  array('Assignee' => array('displayField' => $this->Project->Task->Assignee->displayField), 'Creator' => array('displayField' => 'full_name'));
		$this->set('associations', $associations);
		$this->set('childTasks', $this->_pendingChildTasks($task['Task']['id']));
		$this->set('finishedChildTasks', $this->_completedChildTasks($task['Task']['id']));
		$this->set('parentId', $task['Task']['id']);
		$this->set('model', $task['Task']['model']);
		$this->set('foreignKey', $task['Task']['foreign_key']);
		$this->set('assignees', $this->Project->findUsedUsers($task['Task']['foreign_key'], 'list'));
		$this->set('modelName', 'Task');
		$this->set('pluginName', 'tasks');
		$this->set('displayName', 'name');
		$this->set('displayDescription', 'description'); 
		$this->set('showGallery', true);
		$this->set('galleryModel', array('name' => 'User', 'alias' => 'Assignee'));
		$this->set('galleryForeignKey', 'id');
		$this->set('page_title_for_layout', $project['Project']['displayName']);
		$this->set('tabsElement', '/projects');
		$this->set('pageActions', array(
			array(
				'linkText' => 'All Your Tasks',
				'linkUrl' => array(
					'plugin' => 'tasks',
					'controller' => 'tasks',
					'action' => 'my',
					),
				),
			));
	}
	
	
	protected function _pendingChildTasks($parentTaskId) {
		unset($this->paginate);
		$this->paginate = array(
			'conditions' => array(
				'Task.parent_id' => $parentTaskId,
				'Task.is_completed' => 0,
				),
			'contain' => array(
				'Assignee' => array(
					'fields' => array(
						'id',
						'full_name',
						),
					),
				),
			'fields' => array(
				'id',
				'due_date',
				'assignee_id',
				'name',
				'description',
				),
			'order' => array(
				'Task.order',
				'Task.due_date',
				),
			);
		return $this->paginate('Task');
	}
	
	
	protected function _completedChildTasks($parentTaskId) {
		unset($this->paginate);
		$this->paginate = array(
			'conditions' => array(
				'Task.parent_id' => $parentTaskId,
				'Task.is_completed' => 1,
				),
			'contain' => array(
				'Assignee' => array(
					'fields' => array(
						'id',
						'full_name',
						),
					),
				),
			'fields' => array(
				'id',
				'due_date',
				'completed_date',
				'assignee_id',
				'name',
				'description',
				),
			'order' => array(
				'Task.order',
				'Task.due_date',
				),
			);
		return $this->paginate('Task');
	}
	
	
	/**
	 * @todo	 This send message thing is used here, and in the messages controller itself.  I don't know where we could put it so that its usable between both.  (Probably would have to do some kind of added on, slow component thing).
	 * @todo 	 The task messaging is for the entire task list.  It is not per task, like it should be.  But there is some thought that needs to be put in about who gets notifications for tasks.  Assignee, Assigner, and what if you want someone else in on it.  So the todo, is put in that thought and make it happen. 
	 */
	function _callback_commentsafterAdd($options) {
		
		if ($this->request->params['action'] == 'message') :
			$recipients = $this->Project->Message->findUsedUsers($options['modelId'], 'all');
		elseif ($this->request->params['action'] == 'task') :
			$tasks = $this->Project->Task->find('all', array(
				'conditions' => array(
					'Task.parent_id' => $options['modelId'],
					),
				'contain' => array(
					'Assignee',
					'Creator',
					),
				));
			foreach ($tasks as $task) :
				$recipients[]['User'] = $task['Assignee'];
				$recipients[]['User'] = $task['Creator'];
			endforeach;
		endif;
		# send the message via email
		if (!empty($recipients)) : foreach ($recipients as $recipient) :
			#remove the logged in user, they're the sender
			if ($recipient['User']['id'] != $this->Session->read('Auth.User.id')) : 
				$message = $options['data']['Comment']['body'];
				$message .= '<p>You can reply to this message here: <a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></p>';
				$this->__sendMail($recipient['User']['email'], 'Re: '.$options['data']['Comment']['title'], $message, $template = 'default');
			endif;
		endforeach; endif;
	}
	
	function _callback_commentsFetchDataThreaded($options) {
		if ($this->request->params['action'] == 'message') :
			$options['id'] = $this->request->params['pass'][0];
			$conditions['Comment.foreign_key'] = $options['id'];
			#$conditions['Comment.parent_id'] = 0;
			$conditions['Comment.model'] = 'Message';
			$contain = 'User';
		elseif ($this->request->params['action'] == 'task') :
			$options['id'] = $this->request->params['pass'][0];
			$conditions['Comment.foreign_key'] = $options['id'];
			#$conditions['Comment.parent_id'] = 0;
			$conditions['Comment.model'] = 'Task';
			$contain = 'User';
		endif;
		
		
		$order = array(
			'Comment.parent_id' => 'asc',
			'Comment.created' => 'desc');
		$comments = $this->Project->Comment->find('threaded', compact('conditions', 'contain', 'order'));
		return $comments;
	}
	
	function _callback_commentsAdd($modelId, $commentId, $displayType, $data = array()) {
    	if (!empty($this->request->data)) {
			if ($this->request->params['action'] == 'message') :
				$modelId = $this->request->params['pass'][0];
				$this->Project->name = 'Message';
			elseif ($this->request->params['action'] == 'task') :
				$modelId = $this->request->params['pass'][0];
				$this->Project->name = 'Task';
			endif;
	    }
	    return $this->Comments->callback_add($modelId, $commentId, $displayType, $data);
	} 

}
?>