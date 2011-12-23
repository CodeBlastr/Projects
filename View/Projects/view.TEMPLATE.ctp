<div class="project view">
  <div id="navigation">
    <ul class="tabs">
      <li><a href="#n1">Detail</a></li>
      <li><a href="/admin/projects/">Members</a></li>
      <li><a href="/admin/catalogs">Watchers</a></li>
    </ul>
    <div id="n1" class="info-block">
      <div class="viewRow">
        <ul class="metaData">
          <li class="metaDataPriorityDetail"> <img src="/img/admin/ico22.gif" /> </li>
          <li><span class="metaDataLabel">
            <?php echo __('Days Since Launch: '); ?>
            </span><span class="metaDataDetail"><?php echo floor((time() - strtotime($project['Project']['created'])) / 86400); ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo __($this->Html->link(__('Status: ', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'PROJECTSTATUS', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Status List'))); ?>
            </span><span name="status" class="edit metaDataDetail" id="<?php echo __($project['Project']['id']); ?>"><?php echo $project['ProjectStatusType']['name']; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo __('Estimated Hours: '); ?>
            </span><span name="estimatedhours" class="edit metaDataDetail" id="<?php echo __($project['Project']['id']); ?>"><?php echo $project['Project']['estimated_hours']; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo __('Spent Hours: '); ?>
            </span><span id="spenthours<?php echo $project['Project']['id']; ?>" class="metaDataDetail"><?php echo $trackedHoursSum; ?></span></li>
          <li><span class="metaDataLabel">
            <?php echo __('Percent Complete: '); ?>
            </span><span id="percentcomplete" class="metaDataDetail"><?php echo $percentComplete; __('%'); ?></span></li>
        </ul>
        <div class="recordData">
          <div class="truncate">
            <div class="image"> <img src="/img/admin/img01.jpg" alt="image description" width="76" height="78" /> </div>
            <?php strip_tags(__($project['Project']['description'])); ?>
          </div>
        </div>
      </div>
      <div class="viewRow data">
        <div class="viewHeading toggleClick" name="issues">
          <h6>
            <?php echo __('Tasks') ?>
          </h6>
        </div>
        <div id="issues" class="hide">
          <ul class="actions">
            <li><?php echo $this->Html->link(__('Add Task', true), array( 'controller' => 'project_issues', 'action' => 'edit', 'project_id' => $project['Project']['id'], 'contact_id' => $project['Contact']['id']), array('class' => 'toggleClick', 'name' => 'addIssueForm')); ?></li>
            <li><?php echo $this->Html->link(__('Sort By', true), array('#'), array('class' => 'toggleClickMenu', 'name' => 'sortby')); ?></li>
            <?php
				if ($this->request->params['named']['direction'] == 'asc') {
					$sortDirection = 'desc'; 
				} else {
					$sortDirection = 'asc'; 
				}	
				?>
            <li><?php echo $this->Html->link('Sort by Priority', array($project['Project']['id'], 'sort'=> 'project_issue_priority_type_id', 'direction' => $sortDirection)); ?></li>
            <li><?php echo $this->Html->link('Sort by Due Date', array($project['Project']['id'], 'sort'=> 'due_date', 'direction' => $sortDirection)); ?></li>
            <li><?php echo $this->Html->link('Sort by Name', array($project['Project']['id'], 'sort'=> 'name', 'direction' => $sortDirection)); ?></li>
          </ul>
          <div class="viewForm hide" id="addIssueForm">
          	<fieldset>
            <?php 
				echo $this->Form->create('ProjectIssue', array('action' => 'edit'));
				echo $this->Form->input('ProjectIssue.project_id', array('type' => 'hidden', 'value' => $project['Project']['id']));
				echo $this->Form->input('ProjectIssue.contact_id', array('type' => 'hidden', 'value' => $project['Contact']['id']));				
				#echo $this->Form->input('ProjectIssue.project_tracker_type_id');
				#echo $this->Form->input('ProjectIssue.project_issue_status_type_id');
				#echo $this->Form->input('ProjectIssue.project_issue_priority_type_id');
				echo $this->Form->input('ProjectIssue.name', array('label' => 'Enter a task display name.'));
				echo $this->Form->input('ProjectIssue.description', array('type' => 'richtext', 'label' => 'Enter a task description.', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image', '-', 'Templates'))));
				#echo $this->Form->input('ProjectIssue.start_date');
				echo $this->Form->input('ProjectIssue.due_date', array('label' => 'When is it due?'));
				echo $this->Form->input('ProjectIssue.estimated_hours', array('label' => 'How long should it take?'));
				echo $this->Form->input('ProjectIssue.assignee_id', array('label' => __('Who\'s responsible?', true)));
				echo $this->Form->end('Add Task');
			  ?>
              </fieldset>
          </div>
          <table>
            <tr>
              <th>Assignee</th>
              <th>Subject</th>
              <th></th>
              <th></th>
              <th>Completion</th>
              <th>Priority</th>
              <th>Status</th>
            </tr>
            <?php
			if ($project['ProjectIssue']) {
				foreach ($project['ProjectIssue'] as $issue) { ?>
            <tr class="project-issue <?php echo __($issue['ProjectIssuePriorityType']['name']); ?> <?php echo __($issue['ProjectIssueStatusType']['name']); ?>">
              <!--td><?php echo $this->Form->input('project_issue_id', array('type' => 'checkbox', 'label' => '')); ?></td-->
              <td class="assignee"><?php echo __($issue['Assignee']['username']); ?></td>
              <td><?php echo $this->Html->link(__($issue['name'], true), array('controller'=> 'project_issues', 'action' => 'view', $issue['id'])); # __(' - '.strip_tags($this->Text->truncate($issue['description'], 100, array('ending' => '...', 'html' => true)))); ?></td>
              <td><?php echo __('Start '.$this->Time->timeAgoInWords($issue['start_date'])); ?></td>
              <td><?php echo __('Due '.$this->Time->timeAgoInWords($issue['due_date'])); ?></td>
              <td><?php echo __($issue['done_ratio'].'%'); ?></td>
              <td><?php echo __($issue['ProjectIssuePriorityType']['name']); ?></td>
              <td><?php echo __($issue['ProjectIssueStatusType']['name']); ?></td>
            </tr>
            <?php 
				} 
			}
			?>
          </table>
        </div>
      </div>
      <div class="viewRow data">
        <div class="viewHeading toggleClick" name="members">
          <h6>
            <?php echo __('Members') ?>
          </h6>
        </div>
        <div id="members" class="hide">
          <ul class="actions">
            <li><?php echo $this->Html->link(__('Add Member', true), array('controller' => 'projects_members', 'action' => 'edit', 'project_id' => $project['Project']['id']), array('class' => 'toggleClick', 'name' => 'addmemberform')); ?></li>
          </ul>
          <ul class="member datalist">
            <li class="hide" id="addmemberform">
              <?php 
				echo $this->Form->create('ProjectsMember', array('url'=> array('action'=>'add')));
    			echo $this->Form->input('project_id', array('type' => 'hidden', 'value' => $project['Project']['id']));
				echo $this->Form->input('user_id', array('label' => 'Add User'));
				echo $this->Form->end('Submit');
			?>
            </li>
            <?php
if ($project['Member']) : 
?>
            <?php foreach ($project['Member'] as $member) : ?>
            <li><?php echo $member['username']; ?>
              <p class="action"><?php echo $this->Html->link('Remove', array('controller' => 'projects_members', 'action' => 'delete', 'admin' => 1, $member['ProjectsMember']['id']), array(), 'Are you sure you want to remove "'.$member['username'].'"'); ?></p>
            </li>
            <?php endforeach; ?>
            <?php
endif;
?>
          </ul>
        </div>
      </div>
      <div class="viewRow data">
        <div class="viewHeading toggleClick" name="watchers">
          <h6>
            <?php echo __('Watchers') ?>
          </h6>
        </div>
        <div id="watchers" class="hide">
          <ul class="actions">
            <li><?php echo $this->Html->link(__('Add Watcher', true), array( 'controller' => 'projects_watchers', 'action' => 'edit', 'project_id' => $project['Project']['id']), array('class' => 'toggleClick', 'name' => 'addwatcherform')); ?></li>
          </ul>
          <ul class="watcher datalist">
            <li class="hide" id="addwatcherform">
              <?php 
		  	  echo $this->Form->create('ProjectsWatcher', array('url'=> array('action'=>'add')));
              echo $this->Form->input('project_id', array('type' => 'hidden', 'value' => $project['Project']['id']));
			  echo $this->Form->input('contact_id', array('label' => 'Add Watcher'));
			  echo $this->Form->end('Submit');
		  ?>
            </li>
            <?php
if ($project['Watcher']) : 
?>
            <?php foreach ($project['Watcher'] as $watcher) : ?>
            <?php 
		if (isset($watcher['ContactPerson']['id'])) : 
			$relator = $watcher['ContactPerson']['first_name'].' '.$watcher['ContactPerson']['last_name']; 
			$relator_id = $watcher['ContactPerson']['id']; 
			$relator_ctrl = 'contact_people';
		elseif (isset($watcher['ContactCompany']['id'])) : 
			$relator = $watcher['ContactCompany']['name']; 
			$relator_id = $watcher['ContactCompany']['id']; 
			$relator_ctrl = 'contact_companies';
		else: 
			$relator = null;
		 endif;
		?>
            <li><?php echo $this->Html->link(__($relator, true), array('controller'=> $relator_ctrl, 'action' => 'view', $relator_id)); ?>
              <p class="action"><?php echo $this->Html->link('Remove', array('controller' => 'projects_watchers', 'action' => 'delete', 'admin' => 1, $watcher['ProjectsWatcher']['id']), array(), 'Are you sure you want to remove "'.$relator.'"'); ?></p>
              </p>
            </li>
            <?php endforeach; ?>
            <?php
endif;
?>
          </ul>
        </div>
      </div>
    </div>
    <!-- /info-block end -->
  </div>
</div>
<?php
# state which fields will be editable inline
$editFields = array(
	array(
	  'name' => 'title',
	  'tagId' => $project['Project']['id'],
	  'plugin' => 'projects',
	  'controller' => 'projects',
	  'fieldId' => 'data[Project][id]',
	  'fieldName' => 'data[Project][name]',
	  'type' => 'text'
	  ),
	array(
	  'name' => 'description',
	  'tagId' => $project['Project']['id'],
	  'plugin' => 'projects',
	  'controller' => 'projects',
	  'fieldId' => 'data[Project][id]',
	  'fieldName' => 'data[Project][description]',
	  'type' => 'textarea'
	  ),
	array(
	  'name' => 'status',
	  'tagId' => $project['Project']['id'],
	  'plugin' => 'projects',
	  'controller' => 'projects',
	  'fieldId' => 'data[Project][id]',
	  'fieldName' => 'data[Project][project_status_type_id]',
	  'loadurl' => '/enumerations/index/type:PROJECTSTATUS.json',
	  'type' => 'select'
	  ),
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
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'edit')),
			$this->Html->link(__('List Projects', true), array('controller' => 'projects', 'action' => 'index')),
			$this->Html->link(__('Archive Project', true), array('controller' => 'projects', 'action' => 'archive', $project['Project']['id'])),
			$this->Html->link(__('Un-archive Project', true), array('controller' => 'projects', 'action' => 'unarchive', $project['Project']['id'])),
			)
		),
	array(
		'heading' => 'Project Issues',
		'items' => array(
			$this->Html->link(__('New Issue', true), array('controller' => 'project_issues', 'action' => 'edit', 'project_id' => $project['Project']['id'], 'contact_id' => $project['Contact']['id'])),
			$this->Html->link(__('Show Archived Issued', true), array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id'], 'archive' => 'show')),
			)
		),
	array(
		'heading' => 'Related Contact',
		'items' => array(
			$this->Html->link(__($relator, true), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'view', $project['Contact']['id'])),
			)
		),
	array(
		'heading' => 'Timesheets',
		'items' => array(
			$this->Html->link(__('Add Time', true), array('plugin' => 'timesheets', 'controller' => 'timesheet_times', 'action' => 'edit', 'project_id' => $project['Project']['id'], 'admin' => 1)),
			)
		),
	))); 
?>
<?php $this->set('tabs_for_layout', array(
		array('link' => '/messages/messages/index/Project/'.$project['Project']['id'],
			  'linkText' => 'Messages'),
		array('link' => '/tasks/tasks/index/Project/'.$project['Project']['id'],
			  'linkText' => 'Tasks'),
		array('link' => '/events/events/index/Project/'.$project['Project']['id'],
			  'linkText' => 'Milestones'),
		array('link' => '/users/used/index/Project/'.$project['Project']['id'],
			  'linkText' => 'People'),
		)); ?>
<?php $this->set('page_title_for_layout', $project['Project']['name'].__(' for '.$this->Html->link(__($relator, true), array('plugin' => 'contacts', 'controller'=> 'contacts', 'action' => 'view', $project['Contact']['id'])), true)); ?>
