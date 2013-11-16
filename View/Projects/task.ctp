<div class="tasks view col-md-7">
	<h1><?php echo $task['Task']['name']; ?></h1>
 	<div class="truncate" data-truncate="300"><?php echo $task['Task']['description']; ?></div>
	<h3 class="indexHead">Still pending tasks</h3>
	<div class="list-group">
	<?php foreach ($childTasks as $child) : ?>
		<div class="list-group-item media clearfix">
			<?php echo $this->Html->link($this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $child['Task']['assignee_id'], 'thumbClass' => 'img-thumbnail media-object', 'thumbWidth' => 36, 'thumbHeight' => 36)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id']), array('class' => 'pull-left', 'escape' => false)); // hard coded sizes used on mega buildrr ?>
			<div class="media-body pull-left col-md-6">
				<h5 class="media-heading"><?php echo $this->Html->link($child['Task']['name'], array('action' => 'task', $child['Task']['id'])); ?></h5>
				<div class="truncate" data-truncate="100"><?php echo $child['Task']['description']; ?></div>
			</div>
			<?php echo $this->Html->link('View', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $child['Task']['id']), array('class' => 'badge')); ?>
			<?php echo $this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', $child['Task']['id']), array('class' => 'badge')); ?>
			<?php echo $this->Html->link('Complete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'complete', $child['Task']['id']), array('class' => 'badge')); ?>
			<?php echo $this->Html->link('Delete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', $child['Task']['id']), array('class' => 'badge'), 'Are you sure you want to permanently delete?'); ?>
		</div>
	<?php endforeach; ?>
	</div>
	<hr />
	<h3 class="indexHead toggleClick" data-target=".finished.list-group-item">Completed tasks</h3>
	<div class="list-group">
	<?php foreach ($finishedChildTasks as $child) : ?>
		<div class="finished list-group-item media clearfix">
			<?php echo $this->Html->link($this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $child['Task']['assignee_id'], 'thumbClass' => 'img-thumbnail media-object', 'thumbWidth' => 36, 'thumbHeight' => 36)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id']), array('class' => 'pull-left', 'escape' => false)); // hard coded sizes used on mega buildrr ?>
			<div class="media-body pull-left col-md-6">
				<h5 class="media-heading"><?php echo $this->Html->link($child['Task']['name'], array('action' => 'task', $child['Task']['id'])); ?></h5>
				<div class="truncate" data-truncate="100"><?php echo $child['Task']['description']; ?></div>
			</div>
			<?php echo $this->Html->link('Delete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'delete', $child['Task']['id']), array('class' => 'badge'), 'Are you sure you want to permanently delete?'); ?>
			<?php echo $this->Html->link('InComplete', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'incomplete', $child['Task']['id']), array('class' => 'badge')); ?>
			<?php echo $this->Html->link('Edit', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'edit', $child['Task']['id']), array('class' => 'badge')); ?>
			<?php echo $this->Html->link('View', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'view', $child['Task']['id']), array('class' => 'badge')); ?>
		</div>
	<?php endforeach; ?>
	</div>
</div>

<div class="well well-large span4 col-md-5">
	<div class="tasks form">
		<?php echo $this->Form->create('Task', array('url' => array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'add'))); ?>
	    <fieldset>
	     	<legend><?php echo __('Add task to %s List', $task['Task']['name']); ?></legend>
	      	<?php
			echo $this->Form->input('Task.parent_id', array(
				'type' => 'hidden',
				'value' => $parentId
			));
			echo $this->Form->input('Task.name');
			echo $this->Form->input('Task.due_date');
			echo $this->Form->input('Task.assignee_id');
			echo $this->Form->input('Task.description', array(
				'label' => 'Task details',
				'type' => 'richtext',
				'ckeSettings' => array('buttons' => array(
						'Bold',
						'Italic',
						'Underline',
						'FontSize',
						'TextColor',
						'BGColor',
						'-',
						'NumberedList',
						'BulletedList',
						'Blockquote',
						'JustifyLeft',
						'JustifyCenter',
						'JustifyRight',
						'-',
						'Link',
						'Unlink',
						'-',
						'Image'
					))
			));
			echo $this->Form->input('Task.model', array(
				'type' => 'hidden',
				'value' => $model
			));
			echo $this->Form->input('Task.foreign_key', array(
				'type' => 'hidden',
				'value' => $foreignKey
			));
			echo $this->Form->input('Success.redirect', array(
				'type' => 'hidden',
				'value' => '/projects/projects/task/' . $parentId
			));
			echo $this->Form->end('Submit'); ?>
	    </fieldset>
	</div>
  
  	<hr />
  
  	<div class="tasks form">
	<?php echo $this->Form->create('Task', array('url' => array(
				'plugin' => 'tasks',
				'controller' => 'tasks',
				'action' => 'edit'
			))); ?>
		<fieldset>
	 		<legend class="toggleClick"><?php echo __('Edit %s Task List', $task['Task']['name']); ?></legend>
			<?php
			echo $this->Form->input('Task.id', array(
				'type' => 'hidden',
				'value' => $parentId
			));
			echo $this->Form->input('Task.name', array('value' => $task['Task']['name']));
			echo $this->Form->input('Task.description', array('value' => $task['Task']['description']));
			echo $this->Form->input('Task.model', array(
				'type' => 'hidden',
				'value' => $model
			));
			echo $this->Form->input('Task.foreign_key', array(
				'type' => 'hidden',
				'value' => $foreignKey
			));
			echo $this->Form->end('Submit');
		?>
		</fieldset>
	</div>
</div>
  
 
<?php /* For sorting task priority <script type="text/javascript">
	 $(function() {
	 $(".indexRow").parent().sortable({
	 delay: 300,
	 update: function(event, ui) {
	 $('#loadingimg').show();
	 var taskOrder = $(this).sortable('toArray').toString().replace(/row/g, '');
	 $.post('/tasks/tasks/sort_order.json', {taskOrder:taskOrder},
	 function(data){
	 var n = 1;
	 $.each(data, function(i, item) {
	 $('row.'+item).html(n);
	 n++;
	 });
	 $('#loadingimg').hide()
	 }
	 );
	 }
	 });
	 });
	 </script> */
 ?> 


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('All Projects'), '/projects'),
	$this->Html->link($project['Project']['name'] . ' Homepage', '/projects/projects/view/' . $project['Project']['id']),
	$this->Html->link('Task Lists', '/projects/projects/tasks/' . $project['Project']['id']),
	$task['Task']['name'],
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array( array(
			'heading' => 'Project',
			'items' => array(
				$this->Html->link($project['Project']['name'], array(
					'plugin' => 'projects',
					'controller' => 'projects',
					'action' => 'view',
					$project['Project']['id']
				), array(
					'escape' => false,
					'class' => 'dashboard'
				)),
				$this->Html->link('Messages', array(
					'plugin' => 'projects',
					'controller' => 'projects',
					'action' => 'messages',
					$project['Project']['id']
				), array(
					'title' => 'Messages',
					'escape' => false
				)),
				$this->Html->link('Tasks', array(
					'plugin' => 'projects',
					'controller' => 'projects',
					'action' => 'tasks',
					$project['Project']['id']
				), array(
					'title' => 'Tasks',
					'escape' => false,
					'class' => 'active'
				)),
				$this->Html->link('People', array(
					'plugin' => 'projects',
					'controller' => 'projects',
					'action' => 'people',
					$project['Project']['id']
				), array(
					'title' => 'People',
					'escape' => false
				)),
			)
		), )));
 ?>
