


<div class="tasks form"> <?php echo $this->Form->create('Task' , array('url'=>'/tasks/tasks/add'));?>
  <fieldset>
    <?php
    echo __('<legend class="toggleClick">Tasks Lists <span class="btn btn-primary btn-xs pull-right">Add New Task List</span></legend>');
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
			<?php echo $this->Html->link(__('Add Tasks'), array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'task', $task['Task']['id']), array('class' => 'btn btn-xs pull-right btn-primary')); ?>
		</p>
		<div id="demo<?php echo $task['Task']['id']; ?>" class="collapse <?php echo $expand; ?>"> 
			<div class="list-group">
			<?php foreach ($children as $child) : ?>
				<div class="list-group-item media clearfix">
					<?php echo $this->Html->link($this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $child['Task']['assignee_id'], 'thumbClass' => 'img-thumbnail media-object', 'thumbWidth' => 36, 'thumbHeight' => 36)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id']), array('class' => 'pull-left', 'escape' => false)); // hard coded sizes used on mega buildrr ?>
					<div class="media-body pull-left">
						<h5 class="media-heading"><?php echo $this->Html->link($child['Task']['name'], array('action' => 'task', $child['Task']['id'])); ?></h5>
					</div>
					<?php echo $this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', $child['Task']['id']), array('class' => 'badge')); ?>
					<?php echo $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $child['Task']['id']), array('class' => 'badge')); ?>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php
	$expand = 'collapsed';
	unset($children);
} ?>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('All Projects'), '/projects'),
	$this->Html->link($project['Project']['name'] . ' Homepage', '/projects/projects/view/' . $project['Project']['id']),
	'Task Lists',
)));
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
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false, 'class' => 'active')),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	))); ?>