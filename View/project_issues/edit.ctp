<div class="project-issues form">
<?php echo $this->Form->create('ProjectIssue', array('action' => 'edit'));?>
	<fieldset>
 		<legend><?php __('Edit Activity');?></legend>
	<?php
		echo $this->Form->input('id');
		if (!empty($this->request->params['named']['project_id'])) {
			echo $this->Form->input('project_id', array('type' => 'hidden', 'value' => $this->request->params['named']['project_id']));
		} else {
			echo $this->Form->input('project_id');
		}
		if (!empty($this->request->params['named']['contact_id'])) {
			echo $this->Form->input('contact_id', array('type' => 'hidden', 'value' => $this->request->params['named']['contact_id']));
		} else {
			echo $this->Form->input('contact_id');
		}
		echo $this->Form->input('project_tracker_type_id');
		echo $this->Form->input('project_issue_status_type_id', array('label' => 'Status'));
		echo $this->Form->input('project_issue_priority_type_id');
		echo $this->Form->input('name', array('label' => 'Subject'));
		echo $this->Form->input('description');
		echo $this->Form->input('start_date');
		echo $this->Form->input('due_date');
		echo $this->Form->input('estimated_hours');
		echo $this->Form->input('assignee_id');
		if (!empty($this->request->params['named']['parent_id'])) {
			echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $this->request->params['named']['parent_id']));
		} else {
			echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => ''));
		}
			
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>



<?php 
// set the contextual menu items
$this->Menu->setValue(array(
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
