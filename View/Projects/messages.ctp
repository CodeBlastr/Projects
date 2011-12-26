<div class="messages index">
  <div class="messages form"> <?php echo $this->Form->create('Message' , array('url'=>'/messages/messages/add'));?>
    <fieldset>
      <legend class="toggleClick">
      <h2><?php  echo __("{$project['Project']['displayName']} Messages "); ?></h2>
      <span class="button"><?php echo 'Create a new message.'; ?></span>
      </legend>
      <?php
	 echo $this->Form->input('title', array('label' => __('Subject', true)));
	 echo $this->Form->input('body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	 echo $this->Form->input('User', array('multiple' => 'checkbox', 'label' => 'Select users who will see this message in the list below, and be notified of every comment to this message.'));
	
	 
	 echo $this->Form->input('sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/projects/projects/messages/'.$this->request->data['Message']['foreign_key']));
	 echo $this->Form->input('foreign_key', array('type' => 'hidden'));
	 echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->input('viewPath', array('type' => 'hidden', 'value' => '/projects/projects/message/{messageId}'));
	 echo $this->Form->end(__('Send', true));?>
    </fieldset>
  </div>
  <?php echo $this->Element('scaffolds/index', array(
			'data' => $messages,
			'actions' => array(
				$this->Html->link('Go to message', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'message', '{id}')), 
				$this->Html->link('Add a comment', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'message', '{id}', 'comment' => 0, '#' => 'comments')), 
				)
			));
  ?> 
</div>
