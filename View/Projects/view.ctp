<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false)); ?>

<div class="project view span8 col-md-8">
	<?php if(!empty($project['Project']['description'])) : ?>
		<h3>Project Description</h3>
        <div class="truncate" data-truncate="700"><?php echo $project['Project']['description']; ?></div>
	<?php endif; ?>
</div>

<div class="well well-large span3 col-md-4">
	<div class="list-group">
		<div class="list-group-item"><?php echo __('%s <span class="badge">Launched</span>', ZuhaInflector::datify($project['Project']['created'])); ?></div>
		<div class="list-group-item"><?php echo __('%s <span class="badge">Days Since Launch</span>', floor((time() - strtotime($project['Project']['created'])) / 86400)); ?></div>
		<!--<span class="label label-info"><?php echo __('Time Logged: %s', $trackedHoursSum); ?></span>-->
	</div>
	<?php
	if (!empty($loggedActivities)) { ?>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawLeadsChart);
			 
		function drawLeadsChart() {
			// Create and populate the data table.
			var data = google.visualization.arrayToDataTable([
			['x', 'Date'],
			<?php 
			foreach ($loggedActivities as $activity) { ?>
				['<?php echo date('M d, Y', strtotime($activity['Activity']['created'])); ?>',   <?php echo $activity[0]['count']; ?>],
			<?php } ?>
			]);
					
			// Create and draw the visualization.
			new google.visualization.LineChart(document.getElementById('activities_over_time')).
				draw(data, {
					curveType: "function",
					width: '100%', height: 200,
					legend: {position: 'none'},
					chartArea: {width: '80%', height: '80%'}
					}
				);
		}
		</script>
        
        <h5>Activity since created</h5>
		<div id="activities_over_time"></div>
		
	<?php } ?>
</div>

<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('All Projects'), '/projects'),
	$project['Project']['name'] . ' Homepage'
)));

// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Project',
		'items' => array(
			$this->Html->link($project['Project']['name'], array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', $project['Project']['id']), array('escape' => false, 'class' => 'dashboard active')),
			$this->Html->link('Messages', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'messages', $project['Project']['id']), array('title' => 'Messages', 'escape' => false)),
			$this->Html->link('Tasks', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'tasks', $project['Project']['id']), array('title' => 'Tasks', 'escape' => false)),
			$this->Html->link('People', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'people', $project['Project']['id']), array('title' => 'People', 'escape' => false)),
			)
		),
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Edit'), array('controller' => 'projects', 'action' => 'edit', $project['Project']['id'])),
			)
		),
	))); ?>