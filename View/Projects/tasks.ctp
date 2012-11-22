


<div class="tasks form"> <?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
  <fieldset>
    <?php
    echo __('<legend class="toggleClick">Tasks <span class="btn">Create a Task List</span></legend>');
	echo $this->Form->input('Task.name', array('label' => __('List Name', true)));
	echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => $_SERVER['REQUEST_URI']));
	echo $this->Form->input('Task.foreign_key', array('type' => 'hidden', 'value' => $foreignKey));
	echo $this->Form->input('Task.model', array('type' => 'hidden', 'value' => 'Project'));
	echo $this->Form->end(__('Save', true)); ?>
  </fieldset>
</div>

<?php
$expand = 'in';
foreach ($tasks as $task) {
	foreach ($task['ChildTask'] as $child) {
		$children[]['Task'] = $child;
	}
	echo __('<div class="dashboardBox %s" data-toggle="collapse" data-target="#demo%s"><h3 class="title">%s</h3><div id="demo%s" class="collapse %s"> %s </div></div>', $expand, $task['Task']['id'], $task['Task']['name'], $task['Task']['id'], $expand, !empty($children) ? $this->Element('scaffolds/index', array('data' => $children)) : '<p>There are no unfinished tasks in this list.</p>');
	$expand = 'collapsed';
} ?>

<?php 
//echo $this->Element('scaffolds/index', array(
//	'data' => $tasks,
//	'actions' => array(
//		$this->Html->link('View List', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'task', '{id}')), 
//		$this->Html->link('Delete List', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', '{id}'), array(), 'Are you sure?'), 
//		)
//	)); ?>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link('Dashboard', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'dashboard'), array('title' => 'Dashboard', 'escape' => false)),
			)
		),
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link($project['Project']['displayName'], array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('escape' => false)),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false, 'class' => 'active')),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	))); ?>