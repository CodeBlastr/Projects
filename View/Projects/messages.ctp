<div class="messages index">
  <div class="messages form"> <?php echo $this->Form->create('Message' , array('url'=>'/messages/messages/send'));?>
    <fieldset> 
      <?php
      echo __('<legend class="toggleClick">Messages <span class="btn">Create a Message</span></legend>');
	  echo $this->Form->input('Message.title', array('label' => __('Subject', true)));
	  echo $this->Form->input('Message.body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	  echo $this->Form->input('User', array('multiple' => 'checkbox', 'label' => 'Select users who will see this message in the list below, and be notified of every comment to this message.'));
	  
	  echo $this->Form->input('Message.sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	  echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/projects/projects/messages/'.$this->request->data['Message']['foreign_key']));
	  echo $this->Form->hidden('Message.foreign_key');
	  echo $this->Form->hidden('Message.model', array('value' => 'Project'));
	  echo $this->Form->hidden('Message.viewPath', array('value' => '/projects/projects/message/{messageId}'));
	  echo $this->Form->end(__('Send', true)); ?>
    </fieldset>
  </div>
  <?php 
  echo $this->Element('scaffolds/index', array(
	'data' => $messages,
	'actions' => array(
		$this->Html->link('Go to message', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'message', '{id}')), 
		$this->Html->link('Add a comment', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'message', '{id}', 'comment' => 0, '#' => 'comments')), 
		)
	)); ?> 
</div>


<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link($project['Project']['name'], array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('escape' => false, 'class' => 'dashboard')),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false, 'class' => 'active')),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false)),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	))); ?>