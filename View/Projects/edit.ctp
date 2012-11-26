<div class="project form">
<?php echo $this->Form->create('Project');?>
	<fieldset>
      <legend><?php  echo __("Edit Project"); ?></legend>
		<?php
		echo $this->Form->input('Project.id');
		echo $this->Form->input('Project.name', array('label' => 'Name the project ( ie. "Home page redesign")'));
		echo $this->Form->input('Project.description', array('label' => 'Project scope', 'type' => 'richtext', /*'ckeSettings' => array('buttons' => array('Source', '-', 'Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))*/)); ?>
    </fieldset>
    <fieldset>
    	<legend><p>Who should be able to access this project?</p></legend>
   		<?php
		if (!empty($this->request->params['named']['contact_id'])) {
			echo $this->Form->input('Project.contact_id', array('type' => 'hidden', 'value' => $this->request->params['named']['contact_id']));
		} else {
			echo $this->Form->input('Project.contact_id', array('empty' => '-- Optional --', 'label' => 'Add a company? <small>(or '.$this->Html->link('create a new company', array('plugin' => 'contacts', 'controller' => 'contacts', 'controller' => 'contacts', 'action' => 'add', 'company')).')</small>', 'after' => '<br /><br /><br />'.$this->Form->checkbox('Project.contact_all_access', array('checked' => 'checked')).' Give everyone at this company access to this project?'));
		}
		echo $this->Form->input('Project.user_group_id', array('label' => 'What teams are on this project? <small>(you can add more later)</small>')); ?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>

<?php
$archiveStatusLink = !empty($this->request->data['Project']['is_archived']) ? $this->Html->link(__('Un-archive'), array('controller' => 'projects', 'action' => 'unarchive', $this->request->data['Project']['id']), array('class' => 'archive')) : $this->Html->link(__('Archive'), array('controller' => 'projects', 'action' => 'archive', $this->request->data['Project']['id']), array('class' => 'archive'));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link('Dashboard', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('title' => 'Dashboard', 'escape' => false)),
			)
		),
	array(
		'heading' => 'Projects',
		'items' => array(
			$archiveStatusLink,
			$this->Html->link(__('Delete'), array('controller' => 'projects', 'action' => 'delete', $this->request->data['Project']['id'])),
			)
		),
	array(
		'heading' => 'Time',
		'items' => array(
			$this->Html->link(__('Time'), array('plugin' => 'timesheets', 'controller' => 'timesheet_times', 'action' => 'add', 'project_id' => $this->request->data['Project']['id']), array('escape' => false)),
			)
		),
				
	))); ?>