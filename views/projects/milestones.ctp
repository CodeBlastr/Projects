<div class="messages form">
  <h2><?php echo 'Messages for ' . $project['Project']['name']; ?></h2>
  <fieldset>
	<?php echo $this->Form->create('Message' , array('url'=>'/messages/messages/add'));?>
    <legend class="toggleClick"><?php echo 'Post a new message thread?'; ?></legend>
    <?php
	 echo $this->Form->input('title', array('label' => __('Subject', true)));
	 echo $this->Form->input('foreign_key', array('type' => 'hidden'));
	 echo $this->Form->input('body', array('label' => '', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	 echo $this->Form->input('sender_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	 echo $this->Form->input('model', array('type' => 'hidden', 'value' => 'Project'));
	 echo $this->Form->input('Success.redirect', array('type' => 'hidden', 'value' => '/projects/projects/messages/'.$this->data['Message']['foreign_key']));
	 echo $this->Form->end(__('Send', true));?>
  </fieldset>
</div>

<?php $this->Set('noItems', 'print this message when there are no messages'); ?>

<?php echo $this->Element('scaffolds/index', array('data' => $messages)); ?>