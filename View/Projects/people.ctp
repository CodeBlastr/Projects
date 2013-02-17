<div class="people index">
  <div class="people form"> <?php echo $this->Form->create('Used' , array('url'=>'/projects/projects/used'));?>
    <fieldset>
      <legend class="toggleClick"><?php echo __("People with access to {$project['Project']['displayName']}"); ?> <span class="btn"><?php echo 'Add a new user?'; ?></span></legend>
      <?php
	 echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->input('foreign_key', array('type' => 'hidden', 'value' => $this->request->params['pass'][0]));
	 echo $this->Form->input('role', array('type' => 'hidden', 'value' => 'member'));
	 echo $this->Form->input('user_id', array());
	 echo $this->Form->end(__('Add User', true));?>
    </fieldset>
  </div>
  <?php echo $this->Element('scaffolds/index', array(
		'data' => $people, 
		'actions' => array(
			$this->Html->link('View', array('plugin' => 'users', 'controller' => 'users', 'action' => 'view', '{id}')),
			$this->Html->link('Remove User', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'unuse', '{id}',  "{project[Project][id]}"), array(), 'Are you sure you want to permanently remove?'),
			),
		));
?> </div>


<?php
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
	))); ?>
