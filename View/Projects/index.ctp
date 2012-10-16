<?php echo $this->Element('scaffolds/index', array('data' => $projects)); ?> 

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Create a Project'), array('controller' => 'projects', 'action' => 'add'), array('data-icon' => 'plus')),
			)
		),
	))); ?>