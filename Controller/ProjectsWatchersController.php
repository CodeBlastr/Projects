<?php
/**
 * Projects Watchers Controller
 *
 * This controller handles the logic for adding and editing project watchers.  
 * Project watchers are currently for looks only.  No use is made of them though you could
 * theoretically use the Notifications plugin with them. 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.projects.controllers
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 * @todo		  Watchers are here so that clients can see the project and track the progress without getting full member benefits.  This idea was fully thought out yet, and for it to be fully extensible you would also need to be able to manage project watcher permissions, and so your user role might need to change.  A whole big mess could be made here if you're not careful. 
 */
class ProjectsWatchersController extends ProjectsAppController {

	public $name = 'ProjectsWatchers';
	public $uses = 'Projects.ProjectsWatcher';
	public $allowedActions = array('most_watched');
	
	/**
	 * @todo this admin_ajax_edit probably needs to be removed, and then rerun the default build_acl
	**/
	function admin_ajax_edit($id = null) {
		$model = $this->modelClass;
		$controller = $this->name;
		if (!empty($this->request->data)) {
			if ($this->$model->save($this->request->data)) {
				$this->Session->setFlash(__($model.' saved', true));
			} else {
				$this->Session->setFlash(__('Could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->$model->read(null, $id);
		}
		## this might need to be fixed later, because I'm not 100% sure that 
		## we'll always need a type for the add / edit form
		## define the fields for the form and put them the order you want them displayed;
		## Edit these per controller
		
		#this puts all contacts into one drop down, who are already project members
		$combines = $this->$model->query("SELECT concat(Contact.first_name, ' ', Contact.last_name) AS name, Contact.contact_id FROM contact_people AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM users JOIN `projects_members` on projects_members.user_id = users.id WHERE project_id = ".$this->request->params['named']['project_id'].") UNION SELECT Contact.name AS name, Contact.contact_id FROM contact_companies AS Contact WHERE Contact.contact_id IN (SELECT contact_id FROM users JOIN `projects_members` on projects_members.user_id = users.id WHERE project_id = ".$this->request->params['named']['project_id'].") ORDER BY contact_id");
		foreach ($combines as $combine) :
			$contacts = am($contacts, array($combine[0]['contact_id'] => $combine[0]['name'])); 
		endforeach;		
		$this->set('contacts', $contacts);
		$this->set('fields', array('contact_id','project_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}
	
	function admin_add() {
		$this->__admin_add();
	}

	function most_watched($limit = 5) {
		# for some reason $this->ProjectsWatcher->Project is not working : RK 4/22/2011
		$this->Project = ClassRegistry::init('Projects.Project'); #TODO: why is this necessary here?
		$options = array(
			'joins' => array(
				array(
					'table' => 'projects_watchers',
					'alias' => 'ProjectsWatchers',
					'type' => 'inner',
					'conditions' => array('ProjectsWatchers.project_id = Project.id'),
				)
			),
			'fields' => array('Project.*', 'count(ProjectsWatchers.id) as watchercount'),
			'group' => 'ProjectsWatchers.project_id',
			'order' => 'watchercount DESC',
			'limit' => $limit
		);
		return $this->Project->find('all', $options);
	}//most_watched()

}
?>