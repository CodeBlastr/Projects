<?php 
if(
	$this->request->params['action'] == 'view' || 
	$this->request->params['action'] == 'messages' || 
	$this->request->params['action'] == 'message' || 
	$this->request->params['action'] == 'tasks' || 
	$this->request->params['action'] == 'task' || 
	$this->request->params['action'] == 'milestones' || 
	$this->request->params['action'] == 'people') :

$tabs_for_layout = !empty($tabs_for_layout) ? $tabs_for_layout : array(
	array('action' => array('index'),
		  'link' => $this->Html->link('<span>All Projects</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index'), array('title' => 'Projects', 'escape' => false)),
		  ),
	array('action' => array('view'),
		  'link' => $this->Html->link('<span>Dashboard</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('title' => 'Dashboard', 'escape' => false)),
		  ),
	array('action' => array('message', 'messages'),
		  'link' => $this->Html->link('<span>Messages</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
		  ),
	array('action' => array('task', 'tasks'),
		  'link' => $this->Html->link('<span>Task Lists</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false)),
		  ),
	/*array('action' => 'milestones',
		  'link' => '/projects/projects/milestones/'.$project['Project']['id'],
		  'linkText' => 'Milestones'),*/
	array('action' => array('people'),
		  'link' => $this->Html->link('<span>People</span>', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
		  ),
	);
?>
<div id="<?php echo $this->request->params['controller'].'Tabs'; ?>" class="tab ui-tabs ui-widget">
  <ul id="leadTab" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<?php if (!empty($tabs_for_layout)) : foreach ($tabs_for_layout as $tab) : ?>

    <li class="ui-state-default ui-corner-top <?php echo in_array($this->request->params['action'], $tab['action']) ? 'ui-tabs-selected ui-state-active' : null; ?>"><?php echo $tab['link']; ?></li>

<?php endforeach; endif; ?>

  </ul>
</div>
<?php endif; ?>
