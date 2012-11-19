<?php
// set the contextual sorting items
echo $this->Element('context_sort', array(
    'context_sort' => array(
        'type' => 'select',
        'sorter' => array(array(
            'heading' => '',
            'items' => array(
                $this->Paginator->sort('name'),
                $this->Paginator->sort('created'),
                $this->Paginator->sort('modified'),
                )
            )), 
        )
	)); 

echo $this->Element('forms/search', array(
	'url' => '/projects/projects/index/', 
	'inputs' => array(
		array(
			'name' => 'contains:name', 
			'options' => array(
				'label' => '', 
				'placeholder' => 'Type Your Search and Hit Enter',
				'value' => !empty($this->request->params['named']['contains']) ? substr($this->request->params['named']['contains'], strpos($this->request->params['named']['contains'], ':') + 1) : null,
				)
			),
		)
	));
	
echo $this->Element('scaffolds/index', array(
    'data' => $projects,
	'actions' => array(
		$this->Html->link('View', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', '{id}')),
		$this->Html->link('Edit', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'edit', '{id}')),
		$this->Html->link('Touch', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'touch', '{id}')),
		)
    ));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Create a Project'), array('controller' => 'projects', 'action' => 'add')),
			$this->Html->link(__('Archived Projects'), array('controller' => 'projects', 'action' => 'index', 'filter' => 'archived:1')),
			)
		),
	))); ?>