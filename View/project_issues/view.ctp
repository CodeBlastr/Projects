<?php 
if (isset($projectIssue['Contact']['ContactPerson']['id'])) : 
	$relator = $projectIssue['Contact']['ContactPerson']['first_name'].' '.$projectIssue['Contact']['ContactPerson']['last_name']; 
elseif (isset($projectIssue['Contact']['ContactCompany']['id'])) : 
	$relator = $projectIssue['Contact']['ContactCompany']['name']; 
else: 
	$relator = null;
endif;
?>
 <div class="project view">
	<div class="contactname">
		<h2><span id="projectissuename"><?php __($projectIssue['ProjectIssue']['name']); ?></span> of <?php echo $this->Html->link(__($projectIssue['Project']['name'], true), array('controller'=> 'projects', 'action' => 'view', $projectIssue['Project']['id'])); ?> for <?php echo $this->Html->link(__($relator, true), array('plugin' => null, 'controller'=> 'contacts', 'action' => 'view', $projectIssue['Contact']['id'])); ?></h2>
	</div>
	
<div id="tabscontent">
  <div id="tabContent1" class="tabContent" style="display:yes;">
	<div class="details data">
		<ul class="detail datalist">
			<li>
            	<span class="label"><?php __('Assignee: '); ?></span>
                <span name="assignee" class="edit"  id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['Assignee']['username']); ?></span>
            </li>
			<li>
				<span class="label"><?php echo $this->Html->link(__('Project Tracker', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'PROJECTISSUETRACKER', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Project Tracker List')); ?></span>
	            <span name="tracker" class="edit" id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php echo $projectIssue['ProjectTrackerType']['name']; ?></span>
            </li>
			<li>
            	<span class="label"><?php echo $this->Html->link(__('Priority', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'PROJECTISSUEPRIORITY', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Priority List')); ?></span>
                <span name="priority" class="edit" id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssuePriorityType']['name']); ?></span>
            </li>		
			<li>
            	<span class="label"><?php echo $this->Html->link(__('Status', true), array('plugin' => null, 'controller' => 'enumerations', 'action' => 'index', 'filter' => 'PROJECTISSUESTATUS', 'admin' => 1), array('class' => 'dialog', 'title' => 'Edit Priority List')); ?></span>
                <span name="status" class="edit" id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssueStatusType']['name']); ?></span>
            </li>
        </ul>
		<ul class="detail datalist">
			<li>
            	<span class="label"><?php __('Start Date: '); ?></span>
                <span name="startdate" class="edit" id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssue']['start_date']); ?></span>
            </li>
			<li>
            	<span class="label"><?php __('Due Date: '); ?></span>
                <span name="duedate" class="edit"  id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssue']['due_date']); ?></span>
            </li>
			<li>
            	<span class="label"><?php __('Estimated Hours: '); ?></span>
                <span name="estimatedhours" class="edit"  id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssue']['estimated_hours']); ?></span>
            </li>
			<li>
				<span class="label"><?php __('Spent Hours: '); ?></span>
                <span name="spenthours" id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php echo $trackedHoursSum; ?></span>
            </li>
			<li>
            	<span class="label"><?php __('Done Ratio: '); ?></span>
                <span name="doneratio" class="edit"  id="<?php __($projectIssue['ProjectIssue']['id']); ?>"><?php __($projectIssue['ProjectIssue']['done_ratio']); ?></span>
            </li>
		</ul>
	</div>
	<div class="descriptions data">
		<div class="description">
			<div id="detail<?php echo $projectIssue['ProjectIssue']['id']; ?>"><?php __($projectIssue['ProjectIssue']['description']); ?></div>
		</div>
	</div>
	
    <p class="action"><?php echo $this->Html->link(__('New Message', true), array(''), array('class' => 'toggleClick', 'name' => 'addthreadform'.$projectIssue['ProjectIssue']['id'])); ?></p>	
	<div class="subissues data">
        <div class="issue">	
		  <div id="addthreadform<?php echo $projectIssue['ProjectIssue']['id']; ?>" class="hide">
			<?php echo $this->Form->create('ProjectIssue', array('action' => 'edit'));?>
				<?php
					echo $this->Form->input('name', array('label' =>  'Subject')); 
					echo $this->Form->input('assignee_id', array('label' =>  'Notify / Assign To'));
					echo $this->Form->input('ProjectIssue.description', array('type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
					echo $this->Form->hidden('parent_id', array('value' => $projectIssue['ProjectIssue']['id']));
					echo $this->Form->hidden('project_id', array('value' => $projectIssue['Project']['id']));
					echo $this->Form->hidden('redirect', array('value' => $this->here));
				?>
			<?php echo $this->Form->end('Submit');?>
		  </div>	
		<?php
		if ($projectTree) { 
			foreach ($projectTree[0]['children'] as $branch) { ?>
              <div class="branch-issue detail <?php # echo ($branch['children'][0] ? 'hide' : ''); ?>">	
			  	<p><span class="branch-project-issue-name"><?php echo $this->Html->link(__($branch['ProjectIssue']['name'], true), '', array('class' => 'toggleClick', 'name' => 'branchdescription'.$branch['ProjectIssue']['id'])); ?></span><?php __(' to '.$branch['Assignee']['username']); ?></p>	
            	<div class="hide" id="branchdescription<?php echo $branch['ProjectIssue']['id']; ?>">
            		<?php echo $branch['ProjectIssue']['description']; ?>
	                <div id="extendeddetails<?php echo $branch['ProjectIssue']['id']; ?>" class="hide">
						<p><?php __('Creator '.$branch['Creator']['username']); ?></p>
						<p><?php __('Created '.$time->nice($branch['ProjectIssue']['created'])); ?></p>
	                </div>
    	        	<p class="action"><?php echo $this->Html->link(__('Show Details', true), array(''), array('class' => 'toggleClick', 'name' => 'extendeddetails'.$branch['ProjectIssue']['id']));?><?php echo $this->Html->link(__('Archive', true), array('action' => 'archive', $branch['ProjectIssue']['id'], $branch['ProjectIssue']['project_id']));?><?php echo $this->Html->link(__('Reply', true), array(''), array('class' => 'toggleClick', 'name' => 'replyform'.$branch['ProjectIssue']['id'])); ?></p>
                </div>
				<?php if ($branch['children'][0]) { 
						$branch['children'] = array_reverse($branch['children']);
					  	foreach ($branch['children'] as $child) { ?> 
						<div class="child-issue detail">
	            			<p><span class="child-project-issue-name"><?php echo $this->Html->link(__($child['ProjectIssue']['name'], true), '', array('class' => 'toggleClick', 'name' => 'childdescription'.$child['ProjectIssue']['id'])); ?></span><?php __(' to '.$child['Assignee']['username']); ?></p>	
	                        <div class="hide" id="childdescription<?php echo $child['ProjectIssue']['id']; ?>">
			                <?php __($child['ProjectIssue']['description']); ?>
                            
	               				<div id="extendeddetails<?php echo $child['ProjectIssue']['id']; ?>" class="hide">
									<p><?php __('Creator: '.$child['Creator']['username']); ?></p>
									<p><?php __('Created: '.$time->nice($child['ProjectIssue']['created'])); ?></p>
				                </div>
    	        				<p class="action"><?php echo $this->Html->link(__('Show Details', true), array(''), array('class' => 'toggleClick', 'name' => 'extendeddetails'.$child['ProjectIssue']['id']));?><?php echo $this->Html->link(__('Archive', true), array('action' => 'archive', $child['ProjectIssue']['id'], $child['ProjectIssue']['project_id']));?><?php echo $this->Html->link(__('Reply', true), array(''), array('class' => 'toggleClick', 'name' => 'replyform'.$branch['ProjectIssue']['id'])); ?></p>
	                		</div>
                        </div>
					<?php } ?>
				<?php } ?>	
              </div>	
			<div id="replyform<?php echo $branch['ProjectIssue']['id']; ?>" class="hide">
				<?php echo $this->Form->create('ProjectIssue', array('action' => 'edit'));?>
				<?php
					echo $this->Form->input('name', array('value' => 'Re: '.$branch['ProjectIssue']['name'])); 
					echo $this->Form->input('assignee_id', array('label' =>  'Notify / Assign To'));
					echo $this->Form->input('description', array('id' => 'ProjectIssueReply', 'type' => 'richtext', 'ckeSettings' => array('buttons' => array('Bold','Italic','Underline','FontSize','TextColor','BGColor','-','NumberedList','BulletedList','Blockquote','JustifyLeft','JustifyCenter','JustifyRight','-','Link','Unlink','-', 'Image'))));
					echo $this->Form->hidden('parent_id', array('value' => $branch['ProjectIssue']['id']));
					echo $this->Form->hidden('project_id', array('value' => $projectIssue['Project']['id']));
					echo $this->Form->hidden('redirect', array('value' => $this->here));
				?>
				<?php echo $this->Form->end('Submit');?>
			</div>   
		<?php
            }
		}
		?>
		</div>
	</div>
  </div> 
</div>
<p class="timing"><strong><?php __($projectIssue['ProjectIssue']['name']);?></strong><?php __(' was '); ?><strong><?php __('Created: '); ?></strong><?php echo $time->relativeTime($projectIssue['ProjectIssue']['created']); ?><?php __(', '); ?><strong><?php __('Last Modified: '); ?></strong><?php echo $time->relativeTime($projectIssue['ProjectIssue']['modified']); ?></p>

</div>
<?php

# state which fields will be editable inline
$editFields = array(
	array(
	  'name' => 'tracker',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][project_tracker_type_id]',
	  'loadurl' => '/enumerations/index/type:PROJECTISSUETRACKER.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'priority',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][project_issue_priority_type_id]',
	  'loadurl' => '/enumerations/index/type:PROJECTISSUEPRIORITY.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'status',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][project_issue_status_type_id]',
	  'loadurl' => '/enumerations/index/type:PROJECTISSUESTATUS.json',
	  'type' => 'select'
	  ),
	array(
	  'name' => 'startdate',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][start_date]',
	  'type' => 'text'
	  ),
	array(
	  'name' => 'duedate',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][due_date]',
	  'type' => 'text'
	  ),
	array(
	  'name' => 'estimatedhours',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][estimated_hours]',
	  'type' => 'text'
	  ),
	array(
	  'name' => 'doneratio',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][done_ratio]',
	  'type' => 'text'
	  ),
	array(
	  'name' => 'assignee',
	  'tagId' => $projectIssue['ProjectIssue']['id'],
	  'plugin' => 'projects',
	  'controller' => 'project_issues',
	  'fieldId' => 'data[ProjectIssue][id]',
	  'fieldName' => 'data[ProjectIssue][assignee_id]',
	  'loadurl' => '/admin/users/index.json',
	  'type' => 'select'
	  )
	);
echo $this->element('ajax_edit',  array('editFields' => $editFields));

?>

<?php 
if ($projectIssue['ProjectIssue']['archive'] == 1) {
	$archiveAction = $this->Html->link(__('Un-Archive Issue', true), array('controller' => 'project_issues', 'action' => 'unarchive', $projectIssue['ProjectIssue']['id'], $projectIssue['ProjectIssue']['project_id']));
} else {
	$archiveAction = $this->Html->link(__('Archive Issue', true), array('controller' => 'project_issues', 'action' => 'archive', $projectIssue['ProjectIssue']['id'], $projectIssue['ProjectIssue']['project_id']));
}
// set the contextual menu items
$this->Menu->setValue(array(
	array(
		'heading' => 'Project Manager',
		'items' => array(
			$this->Html->link(__('New Project', true), array('controller' => 'projects', 'action' => 'edit')),
			$this->Html->link(__('New Issue', true), array('controller' => 'project_issues', 'action' => 'edit', 'project_id' => $projectIssue['ProjectIssue']['project_id'], 'contact_id' => $projectIssue['ProjectIssue']['contact_id'])),
			$archiveAction,
			$this->Html->link(__('Include Archived', true), array($projectIssue['ProjectIssue']['id'], 'archive' => 'show')),
			)
		),
	array(
		'heading' => 'Timesheets',
		'items' => array(
			$this->Html->link(__('Add Time', true), array('plugin' => 'timesheets', 'controller' => 'timesheet_times', 'action' => 'edit', 'project_id' => $projectIssue['ProjectIssue']['project_id'], 'project_issue_id' => $projectIssue['ProjectIssue']['id'])),
			)
		),
	)
);
?>

<?php # pr($projectTree); ?>