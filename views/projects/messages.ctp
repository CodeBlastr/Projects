<div class="messages index">
  <div class="messages form">
    <h2><?php echo 'Messages for ' . $project['Project']['displayName']; ?></h2>
    <fieldset>
      <?php echo $this->Form->create('Message' , array('url'=>'/messages/messages/add'));?>
      <legend class="toggleClick"><?php echo 'Post a new message thread?'; ?></legend>
      <?php
	 echo $this->Form->input('title', array('label' => __('Subject', true)));
	 echo $this->Form->input('body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	 echo $this->Form->input('User', array('multiple' => 'checkbox', 'label' => 'Select users who will see this message in the list below, and be notified of every comment to this message.'));
	
	 
	 echo $this->Form->input('sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/projects/projects/messages/'.$this->data['Message']['foreign_key']));
	 echo $this->Form->input('foreign_key', array('type' => 'hidden'));
	 echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->input('viewPath', array('type' => 'hidden', 'value' => '/projects/projects/message/{messageId}'));
	 echo $this->Form->end(__('Send', true));?>
    </fieldset>
  </div>
  <?php $this->Set('noItems', 'print this message when there are no messages'); ?>
  <?php echo $this->Element('scaffolds/index', array(
			'data' => $messages,
			'actions' => array(
				$this->Html->link('View Comments', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'message', '{id}')), 
				)
			));
  ?>
</div>