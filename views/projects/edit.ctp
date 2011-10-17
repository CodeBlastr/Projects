<div class="project form">
<?php echo $form->create('Project');?>
	<fieldset>
	<?php
		echo $form->input('Project.id');
		echo $form->input('Project.name', array('label' => 'Name the project ( ie. "Home page redesign")'));
		#echo $form->input('Project.description', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
	?>
    </fieldset>
    <fieldset>
    	<legend><p>Who should be able to access this project?</p></legend>
    <?php
		if (!empty($this->params['named']['contact_id'])) {
			echo $form->input('Project.contact_id', array('type' => 'hidden', 'value' => $this->params['named']['contact_id']));
		} else {
			echo $form->input('Project.contact_id', array('empty' => '-- Optional --', 'label' => 'Add a company? <small>(or '.$this->Html->link('create a new company', array('plugin' => 'contacts', 'controller' => 'contacts', 'controller' => 'contacts', 'action' => 'add', 'company')).')</small>', 'after' => '<br /><br /><br />'.$form->checkbox('Project.contact_all_access', array('checked' => 'checked')).' Give everyone at this company access to this project?'));
		}
		echo $form->input('Project.user_group_id', array('label' => 'What teams are on this project? <small>(you can add more later)</small>'));
			
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<?php 
// set the contextual menu items
$menu->setValue(array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('List', true), array('controller' => 'projects', 'action' => 'index')),
			$this->Html->link(__('Add', true), array('controller' => 'projects', 'action' => 'add')),
			$this->Html->link('Delete', array('controller' => 'projects', 'action' => 'delete', $this->data['Project']['id']), array(), 'Are you sure you want to delete "'.strip_tags($this->data['Project']['displayName']).'"')
		)
	),
));
?>