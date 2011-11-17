<div class="project view">
    <h2><?php  echo __("{$project['Project']['displayName']} Dashboard"); ?></h2>
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
          <?php echo $this->Element('activities', array('parentForeignKey' => $project['Project']['id']), array('plugin' => 'activities')); ?> </div>
      </div>
    </div>
  <!-- /info-block end -->
</div>
<?php
# state which fields will be editable inline
$editFields = array(
	array(
	  'name' => 'estimatedhours',
	  'tagId' => $project['Project']['id'],
	  'plugin' => 'projects',
	  'controller' => 'projects',
	  'fieldId' => 'data[Project][id]',
	  'fieldName' => 'data[Project][estimated_hours]',
	  'type' => 'text'
	  ),
	);

echo $this->element('ajax_edit',  array('editFields' => $editFields));
?>
<?php
// set the contextual menu items
echo $this->Element('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link(__('Edit', true), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id']), array('class' => 'edit')),
			$this->Html->link(__('Archive', true), array('controller' => 'projects', 'action' => 'archive', $project['Project']['id']), array('class' => 'archive')),
			$this->Html->link(__('Un-archive', true), array('controller' => 'projects', 'action' => 'unarchive', $project['Project']['id']), array('class' => 'archive')),
			)
		),
	array(
		'heading' => 'Timesheets',
		'items' => array(
			$this->Html->link(__('Time', true), array('plugin' => 'timesheets', 'controller' => 'timesheet_times', 'action' => 'add', 'project_id' => $project['Project']['id']), array('class' => 'add')),
			)
		),
	))); 
?>
