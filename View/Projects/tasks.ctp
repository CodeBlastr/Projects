<div class="tasks form"> <?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
  <fieldset>
    <legend class="toggleClick"><?php  echo __("{$project['Project']['displayName']} Task Lists "); ?><span class="button"><?php echo 'Create a new task list?'; ?></span></legend>
    <?php
	 echo $this->Form->input('Task.name', array('label' => __('List Name', true)));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => $_SERVER['REQUEST_URI']));
	 echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
	 echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->end(__('Save', true));?>
  </fieldset>
</div>
<?php echo $this->Element('scaffolds/index', array(
		'data' => $tasks,
		'actions' => array(
			$this->Html->link('View List', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'task', '{id}')), 
			$this->Html->link('Delete List', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', '{id}'), array(), 'Are you sure?'), 
			)
		)); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link('<span>Dashboard</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('title' => 'Dashboard', 'escape' => false)),
			$this->Html->link('<span>Messages</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('<span>Tasks</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false, 'class' => 'ui-btn-active')),
			$this->Html->link('<span>People</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	))); ?>