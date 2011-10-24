<div class="accordion">
  <ul>
    <li> <a href="#"><span>Support</span></a>
  </ul>
  <ul>
    <li><?php echo $this->Html->link('Projects', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Timesheets', array('plugin' => 'timesheets', 'controller' => 'timesheets', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Tasks', array('plugin' => 'tasks', 'controller' => 'tasks', 'action' => 'my')); ?></li>
    <li><?php echo $this->Html->link('Tickets', array('plugin' => 'tickets', 'controller' => 'tickets', 'action' => 'index')); ?></li>
  </ul>
</div>