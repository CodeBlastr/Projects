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
	)); ?>
<div class="row projects index">
    <div class="well well-large pull-right last span4">
        <?php
        echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false));
        //if (!empty($leadActivities)) { 
        echo '<h4>Time Since Last Touch</h4>'; ?>

        <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawLastTouchChart);
        function drawLastTouchChart() {
            // Create and populate the data table.
            var data = google.visualization.arrayToDataTable([
              ['Project', 'Days'],
              <?php
              $height = count($projects) * 70;
              $today = time();
              foreach ($projects as $project) {
                $modified = strtotime($project['Project']['modified']);
                $elapsed = floor(($today - $modified) / (60 * 60 * 24));

                echo __('[\'%s\',  %s],', strip_tags($project['Project']['displayName']), $elapsed); 
              }?>
            ]);

            // Create and draw the visualization.
            new google.visualization.BarChart(document.getElementById('time_since_last_touch')).
                draw(data, {
                    backgroundColor: '#F5F5F5',
                    vAxis: {
                        textPosition: 'in',
                        },
                    title:"",
                    legend: {position: 'none'},
                    width: '100%', 
                    height:<?php echo $height; ?>,
                    chartArea: {width: '99%', height: '99%'}
                    }
                );
          }


        google.setOnLoadCallback(drawLastTouchChart);
        </script>
        <div id="time_since_last_touch"></div>
        <?php
        //} 
        //
        //if (!empty($loggedActivities)) { ?>
        <h5>Activity over time</h5>
		<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawLeadsChart);
			 
		function drawLeadsChart() {
			// Create and populate the data table.
			var data = google.visualization.arrayToDataTable([
			['x', 'Date'],
			<?php 
			foreach ($loggedActivities as $activity) { ?>
				['<?php echo date('M d, Y', strtotime($activity['Activity']['created'])); ?>',   <?php echo $activity['Activity']['COUNT(Activity.created)']; ?>],
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
			$(".masonry").masonry("reload"); // reload the layout
		}
		</script>
        
		<div id="activities_over_time"></div>
		
        <?php
        //} ?>
    </div>
    <div class="span7">
<?php
echo $this->Element('scaffolds/index', array(
    'data' => $projects,
	'actions' => array(
		$this->Html->link('View', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'view', '{id}')),
		$this->Html->link('Edit', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'edit', '{id}')),
		$this->Html->link('Touch', array('plugin' => 'projects', 'controller' => 'projects', 'action' => 'touch', '{id}')),
		)
    )); ?>
    </div>
</div>

<?php
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Archived Projects'), array('controller' => 'projects', 'action' => 'index', 'filter' => 'archived:1')),
			$this->Html->link(__('Add Project'), array('controller' => 'projects', 'action' => 'add')),
			)
		),
	))); ?>