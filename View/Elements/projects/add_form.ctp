<div class="project form">
<?php echo $this->Form->create('Project');?>
	<fieldset>
      <legend>
      <h2><?php  echo __("Create a Project"); ?></h2>
      </legend>
	<?php
		echo $this->Form->input('Project.name', array('label' => 'Name the project ( ie. "Home page redesign")'));
		#echo $this->Form->input('Project.description', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	?>
    	<legend><p>Who should be able to access this project?</p></legend>
    <?php
		echo $this->Form->input('Project.contact_id', array('empty' => '-- Optional --', 'value' => $contactId, 'label' => 'Which client? <small>(or '.$this->Html->link('create a new company', array('plugin' => 'contacts', 'controller' => 'contacts', 'controller' => 'contacts', 'action' => 'add', 'company')).')</small>', 'after' => '<br /><br /><br />'.$this->Form->checkbox('Project.contact_all_access', array('checked' => 'checked')).' Give everyone at this company access to this project?'));
		echo $this->Form->input('Project.user_group_id', array('label' => 'What teams are on this project? <small>(you can add more later)</small>'));
			
	?>
<?php echo $this->Form->end('Submit');?>
	</fieldset>
</div>