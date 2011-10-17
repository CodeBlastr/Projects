<div class="tasks form">
  <h2><?php echo __('Task Lists '); ?></h2>
  <fieldset>
	<?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
    <legend class="toggleClick"><?php echo 'Create a new task list?'; ?></legend>
    <?php
	 echo $this->Form->input('Task.name', array('label' => __('List Name', true)));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/projects/projects/tasks/'.$this->data['Task']['foreign_key']));
	 echo $this->Form->input('Task.foreign_key', array('type' => 'hidden'));
	 echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->end(__('Save', true));?>
  </fieldset>
</div>

<?php $this->Set('noItems', 'print this message when there are no tasks'); ?>

<?php echo $this->Element('scaffolds/index', array(
		'data' => $tasks,
		'actions' => array(
			$this->Html->link('View Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'task', '{id}')), 
			)
		)); 
?>