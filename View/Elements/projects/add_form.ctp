<div class="project form">
<?php echo $this->Form->create('Project');?>
	<fieldset>
	<?php
	echo $this->Form->input('Project.name', array('label' => 'Name the project ( ie. "Home page redesign")'));
	echo $this->Form->input('Project.contact_id', array('empty' => '-- Optional --', 'value' => $contactId, 'label' => 'Who should be able to access this project? <small>(or '.$this->Html->link('create a new company', array('plugin' => 'contacts', 'controller' => 'contacts', 'controller' => 'contacts', 'action' => 'add', 'company'), array('class' => 'toggleClick', 'data-target' => '#ContactNameDiv')).')</small>', 'after' => '&nbsp;'.$this->Form->checkbox('Project.contact_all_access', array('checked' => 'checked')).' Give everyone at this company access to this project?'));
	echo $this->Form->input('Contact.name', array('label' => 'Company Name', 'div' => array('id' => 'ContactNameDiv')));
	echo $this->Form->input('Contact.is_company', array('type' => 'hidden', 'value' => 1));
	echo $this->Form->input('Project.user_group_id', array('label' => 'Which team do you have on this project?')); ?>
	</fieldset>
    <?php echo $this->Form->end('Submit'); ?>
</div>