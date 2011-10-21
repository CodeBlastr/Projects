<div class="people index">
  <div class="people form">
    <h2><?php echo 'Manage user access for  ' . $project['Project']['displayName']; ?></h2>
    <fieldset>
      <?php echo $this->Form->create('Used' , array('url'=>'/projects/projects/used'));?>
      <legend class="toggleClick"><?php echo 'Add a new user to this project'; ?></legend>
      <?php
	 echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->input('foreign_key', array('type' => 'hidden', 'value' => $project['Project']['id']));
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
?>
</div>