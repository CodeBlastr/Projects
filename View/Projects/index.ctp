<?php echo $this->Html->script('http://code.highcharts.com/highcharts.js', array('inline' => false)); ?>
<?php echo $this->Html->script('http://code.highcharts.com/modules/exporting.js', array('inline' => false)); ?>

<div class="row projects index">
    <div class="span6 col-md-7">
    	<?php if (!empty($projects)) : ?>
    	<h4>Fulfill a Promise Today!</h4>
    	<div class="list-group">
    		<?php foreach ($projects as $project) : ?>
    			<div class="list-group-item">
    				<?php echo $this->Html->link($project['Project']['name'], array('action' => 'view', $project['Project']['id'])); ?>
    				<?php echo $this->Html->link('Touch', array('action' => 'touch', $project['Project']['id']), array('class' => 'badge')); ?>
    			</div>
        	<?php endforeach; ?>
        </div>
        <?php echo $this->element('paging'); ?>
        <?php else : ?>
        	<h3>No results found.</h3>
        <?php endif; ?>
    </div>
    
    
    <div class="col-lg-5">
    	<h4>These People Would Love to Hear From You!</h4>
        <div class="well well-large" id="lastTouch" style="min-width: 100px; height: <?php echo $height; ?>px; margin: 0 auto;"></div>
    </div>
</div>



<script type="text/javascript">
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'lastTouch',
                type: 'bar',
                backgroundColor: '#F5F5F5',
            },
            title: {
                text: false
            },
            subtitle: {
                text: false
            },
            xAxis: {
                categories: [' '],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: null,
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +' days';
                }
            },
            plotOptions: {
                bar: {
                    groupPadding: 0.02,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: false,
            credits: {
                enabled: false
            },
            series: [
                <?php
                $height = count($projects) * 50;
                $today = time();
                $bars = array_reverse($projects);
                foreach ($bars as $bar) {
                  $modified = strtotime($bar['Project']['modified']);
                  $elapsed = floor(($today - $modified) / (60 * 60 * 24));
				  
				  if ( $elapsed >= 28 ) $color = '#FF0000';
				  elseif ( $elapsed >= 21 ) $color = '#FF5200';
				  elseif ( $elapsed >= 14 ) $color = '#FFBB00';
				  elseif ( $elapsed >= 7 ) $color = '#FFFE00';
				  else $color = '#51FF00';
				  
                  echo __('{name: \'%s\', data: [%s], color: \'%s\', dataLabels: { enabled: true, align: \'right\', formatter: function() {return "%s, <small>Last touched %s days ago</small>"}}},', strip_tags($bar['Project']['name']), $elapsed, $color, strip_tags($bar['Project']['name']), $elapsed); 
                }?>
            ]
        });
    });
</script>
        
        
        
<?php
// set the contextual breadcrumb items
$this->set('context_crumbs', array('crumbs' => array(
	$this->Html->link(__('Admin Dashboard'), '/admin'),
	'Projects Dashboard',
)));

// set the contextual sorting items
//echo $this->Element('context_sort', array(
//    'context_sort' => array(
//        'type' => 'select',
//        'sorter' => array(array(
//            'heading' => '',
//            'items' => array(
//                $this->Paginator->sort('name'),
//                $this->Paginator->sort('created'),
//                $this->Paginator->sort('modified'),
//                )
//            )), 
//        )
//    )); 
    
// set contextual search options
$this->set('formsSearch', array(
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
    
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('List'), array('controller' => 'projects', 'action' => 'index', 'filter' => 'archived:0')),
			$this->Html->link(__('List Archived'), array('controller' => 'projects', 'action' => 'index', 'filter' => 'archived:1')),
			$this->Html->link(__('Add'), array('controller' => 'projects', 'action' => 'add')),
			)
		),
	))); ?>