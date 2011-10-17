<?php
App::import(array(
	'type' => 'File', 
	'name' => 'Projects.ProjectsConfig', 
	'file' =>  '..' . DS . 'plugins'  . DS  . 'projects'  . DS  . 'config'. DS .'core.php'
));

class ProjectsAppController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();		
		$Config = ProjectsConfig::getInstance();
		#sets display values
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View'])) {
			$this->set('settings', $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'View']);
		}
		if (!empty($Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'])) {
			$this->settings = $Config->settings[$this->params['controller'].Inflector::camelize($this->params['action']).'Controller'];
		}
	}
	
}
?>