<?php echo $this->Html->script('http://code.highcharts.com/highcharts.js', array('inline' => false)); ?>
<?php echo $this->Html->script('http://code.highcharts.com/modules/exporting.js', array('inline' => false)); ?>

<div class="row projects index">
    <div class="well well-large pull-right last span5">
        <?php
        echo '<h4>Time Since Last Touch</h4>'; ?>
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

                      echo __('{name: \'%s\', data: [%s]},', strip_tags($bar['Project']['displayName']), $elapsed); 
                    }?>
                ]
            });
        });
        </script>
        <div id="lastTouch" style="min-width: 100px; height: <?php echo $height; ?>px; margin: 0 auto;"></div>
    </div>
    <div class="span6">
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
$this->set('forms_search', array(
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
			$this->Html->link(__('Archived Projects'), array('controller' => 'projects', 'action' => 'index', 'filter' => 'archived:1')),
			$this->Html->link(__('Add'), array('controller' => 'projects', 'action' => 'add')),
			)
		),
	))); ?>