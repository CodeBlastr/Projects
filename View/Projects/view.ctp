<div class="well well-large pull-right last span4">
   <p>Put a graph here or some kind of visual information</p>
</div>


<div class="project view">
    <h2><?php echo __('Dashboard'); ?></h2>
    <div id="n1" class="info-block">
      <div class="viewRow">
        <?php if ($this->Session->read('Auth.User.user_role_id') == 1) : ?>
        <ul class="metaData">
          <li><span class="metaDataLabel"> <?php echo __('Days Since Launch: '); ?> </span><span class="metaDataDetail"><?php echo floor((time() - strtotime($project['Project']['created'])) / 86400); ?></span></li>
          <!--li><span class="metaDataLabel">
            <?php echo __('Estimated Hours: '); ?>
            </span><span name="estimatedhours" class="edit metaDataDetail" id="<?php echo __($project['Project']['id']); ?>"><?php echo $project['Project']['estimated_hours']; ?></span></li-->
          <li><span class="metaDataLabel"> <?php echo __('Time Logged: '); ?> </span><span id="spenthours<?php echo $project['Project']['id']; ?>" class="metaDataDetail"><?php echo $trackedHoursSum; ?></span></li>
          <!--li><span class="metaDataLabel">
            <?php echo __('Percent Complete: '); ?>
            </span><span id="percentcomplete" class="metaDataDetail"><?php echo $percentComplete; __('%'); ?></span></li-->
        </ul>
        <?php endif; ?>
        <div class="recordData">
          <h3><?php echo __('Latest Activities'); ?></h3>
          <?php echo $this->Element('activities', array('parentForeignKey' => $project['Project']['id']), array('plugin' => 'activities')); ?>
        </div>
      </div>
    </div>
  <!-- /info-block end -->
</div>

<?php
$archiveStatusLink = !empty($project['Project']['is_archived']) ? $this->Html->link(__('Un-archive'), array('controller' => 'projects', 'action' => 'unarchive', $project['Project']['id']), array('class' => 'archive')) : $this->Html->link(__('Archive'), array('controller' => 'projects', 'action' => 'archive', $project['Project']['id']), array('class' => 'archive'));
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link('Dashboard', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('title' => 'Dashboard', 'class' => 'active')),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages')),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks')),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People')),
			)
		),
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id'])),
			$archiveStatusLink,
			$this->Html->link(__('<i class="icon-plus"></i> Time'), array('plugin' => 'timesheets', 'controller' => 'timesheet_times', 'action' => 'add', 'project_id' => $project['Project']['id']), array('escape' => false)),
			$this->Html->link(__('Projects'), array('controller' => 'projects', 'action' => 'index')),
			//$this->Html->link($project['Contact']['name'], array('plugin' => 'contacts', 'controller' => 'contacts', 'action' => 'view', $project['Project']['contact_id'])),
			)
		),
				
	))); ?>