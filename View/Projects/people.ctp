<div class="people index">
  <div class="people form"> <?php echo $this->Form->create('Used' , array('url'=>'/projects/projects/used'));?>
    <fieldset>
      <legend class="toggleClick">
      <h2><?php echo __("People with access to {$project['Project']['displayName']}"); ?></h2>
      <span class="button"><?php echo 'Add a new user?'; ?></span>
      </legend>
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
?> </div>
