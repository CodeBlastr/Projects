<div class="people index">
	<div class="people form"> 
		<?php echo $this->Form->create('Used' , array('url'=>'/projects/projects/used'));?>
		<fieldset>
			<legend class="toggleClick"><?php echo __("People with access to {$project['Project']['displayName']}"); ?> <span class="btn btn-primary btn-xs"><?php echo 'Add a new user?'; ?></span></legend>
			<?php echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project')); ?>
			<?php echo $this->Form->input('foreign_key', array('type' => 'hidden', 'value' => $this->request->params['pass'][0])); ?>
			<?php echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'member')); ?>
			<?php echo $this->Form->input('user_id', array()); ?>
			<?php echo $this->Form->end(__('Add User', true)); ?>
    	</fieldset>
	</div>
	
	<div class="list-group">
	<?php foreach ($people as $person) : ?>
		<div class="list-group-item media clearfix">
			<?php echo $this->Html->link($this->element('Galleries.thumb', array('model' => 'User', 'foreignKey' => $person['User']['id'], 'thumbClass' => 'img-thumbnail media-object', 'thumbWidth' => 36, 'thumbHeight' => 36)), array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id']), array('class' => 'pull-left', 'escape' => false)); // hard coded sizes used on mega buildrr ?>
			<div class="media-body pull-left">
				<h5 class="media-heading"><?php echo $this->Html->link($person['User']['full_name'], array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', $person['User']['id'])); ?></h5>
			</div>
			<?php echo $this->Html->link('Remove User', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'unuse', '{id}',  "{project[Project][id]}"), array('class' => 'badge'), 'Are you sure you want to permanently remove?'); ?>
		</div>
	<?php endforeach; ?>
	</div>
</div>


<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('All Projects'), '/projects'),
	$this->Html->link($project['Project']['name'] . ' Homepage', '/projects/projects/view/' . $project['Project']['id']),
	'People',
)));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link($project['Project']['name'], array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('escape' => false, 'class' => 'dashboard')),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false)),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false, 'class' => 'active')),
			)
		),
	)));
