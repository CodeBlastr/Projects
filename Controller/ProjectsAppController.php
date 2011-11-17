<?php
class ProjectsAppController extends AppController {
	
	function beforeFilter() {
		parent::beforeFilter();
		if ($this->request->params['action'] != 'index') : 
			$this->set('quickNavAfterBack_callback', '<a href="/projects" class="back">All Projects</a>');
		endif;
	}
	
}
?>