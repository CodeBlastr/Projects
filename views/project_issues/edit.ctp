<div class="project-issues form">
<?php echo $form->create('ProjectIssue', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Activity');?></legend>
	<?php
		echo $form->input('id');
		if (!empty($this->params['named']['project_id'])) {
			echo $form->input('project_id', array('type' => 'hidden', 'value' => $this->params['named']['project_id']));
		} else {
			echo $form->input('project_id');
		}
		if (!empty($this->params['named']['contact_id'])) {
			echo $form->input('contact_id', array('type' => 'hidden', 'value' => $this->params['named']['contact_id']));
		} else {
			echo $form->input('contact_id');
		}
		echo $form->input('project_tracker_type_id');
		echo $form->input('project_issue_status_type_id', array('label' => 'Status'));
		echo $form->input('project_issue_priority_type_id');
		echo $form->input('name', array('label' => 'Subject'));
		echo $form->input('description');
		echo $form->input('start_date');
		echo $form->input('due_date');
		echo $form->input('estimated_hours');
		echo $form->input('assignee_id');
		if (!empty($this->params['named']['parent_id'])) {
			echo $form->input('parent_id', array('type' => 'hidden', 'value' => $this->params['named']['parent_id']));
		} else {
			echo $form->input('parent_id', array('type' => 'hidden', 'value' => ''));
		}
			
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>



<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Project Manager',
		'items' => array(
			$this->Html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'edit')),
			$this->Html->link(__('New Project Issue', true), array('controller' => 'project_issues', 'action' => 'edit')),
			)
		),
	array(
		'heading' => 'Timesheets',
		'items' => array(
			$this->Html->link(__('Add Time', true), array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'edit')),
			)
		),
	)
);
?>
