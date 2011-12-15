<?php
/**
 * Projects Members Controller
 *
 * This controller handles the logic for adding and editing project members.  
 * Project members are the only users who can be assigned project issues.
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
 * @todo		  Make it so that the project manager is automatically a member of the project.
 * @todo		  Find a more efficient way to add project members, maybe in the side bar, like on codemyconcept.com's pm.
 */
class ProjectsMembersController extends ProjectsAppController {

	public $name = 'ProjectsMembers';
	public $uses = 'Projects.ProjectsMember';

	/**
	 * @ todo this admin_ajax_edit probably needs to be removed (and then reset build_acl original)
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
		$users = $this->$model->User->find('list');
		$this->set(compact('users'));
		$this->set('fields', array('user_id','project_id'));
		## End edit per controller
		$this->set('model', $model);
		$this->set('controller', $controller);
		$this->viewPath = 'pages';
		$this->render('ajax_edit');
	}
	
	function admin_add() {
		$this->__admin_add();
	}
}
?>