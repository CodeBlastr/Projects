


<div class="tasks form"> <?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
  <fieldset>
    <?php
    echo __('<legend class="toggleClick">Tasks Lists <span class="btn pull-right">Add New Task List</span></legend>');
	echo $this->Form->input('Task.name', array('label' => __('New List Name')));
	echo $this->Form->input('Task.description');
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
	} ?>
	<div class="dashboardBox <?php echo $expand; ?>">
		<h3 class="title" data-toggle="collapse" data-target="#demo<?php echo $task['Task']['id']; ?>"> <?php echo $task['Task']['name']; ?> </h3>
		<p>
			<small><?php echo __('<span class="badge badge-info">%s</span> unfinished tasks.  List created on %s. %s', @count($children), ZuhaInflector::datify($task['Task']['created']), strip_tags($task['Task']['description'])); ?></smalL>
			<?php echo $this->Html->link(__('Edit'), array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'task', $task['Task']['id']), array('class' => 'btn btn-mini pull-right')); ?>
		</p>
		<div id="demo<?php echo $task['Task']['id']; ?>" class="collapse <?php echo $expand; ?>"> 
			<?php echo !empty($children) ? $this->Element('scaffolds/index', array('data' => $children, 'modelName' => 'Task', 'actions' => array(
				$this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', '{id}')),
				$this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', '{id}')),
				))) : null; ?>
		</div>
	</div>
	<?php
	$expand = 'collapsed';
	unset($children);
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
		'heading' => 'Project',
		'items' => array(
			$this->Html->link($project['Project']['name'], array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('escape' => false, 'class' => 'dashboard')),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false, 'class' => 'active')),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	))); ?>