<?php
/**
 * Most Watched Projects Element 
 *
 * PHP versions 5
 *
 * Zuha(tm) : Business Management Applications (http://zuha.com)
 * Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.org)
 *
 * Licensed under GPL v3 License
 * Must retain the above copyright notice and release modifications publicly.
 *
 * @copyright     Copyright 2009-2010, Zuha Foundation Inc. (http://zuha.com)
 * @link          http://zuha.com Zuha™ Project
 * @package       zuha
 * @subpackage    zuha.app.plugins.projects.views.elements
 * @since         Zuha(tm) v 0.0.1
 * @license       GPL v3 License (http://www.gnu.org/licenses/gpl.html) and Future Versions
 */
	# this should be at the top of every element created with format __ELEMENT_PLUGIN_ELEMENTNAME_instanceNumber.
 	# it allows a database driven way of configuring elements, and having multiple instances of that configuration.
	if(!empty($instance) && defined('__ELEMENT_PROJECTS_MOST_WATCHED_'.$instance)) {
		extract(unserialize(constant('__ELEMENT_PROJECTS_MOST_WATCHED_'.$instance)));
	} else if (defined('__ELEMENT_PROJECTS_MOST_WATCHED')) {
		extract(unserialize(__ELEMENT_PROJECTS_MOST_WATCHED));
	}

// options
$moduleTitle = !empty($moduleTitle) ? $moduleTitle : 'Most Watched Projects';
$numberOfProjects = !empty($numberOfProjects) ? $numberOfProjects : 5;

$projectsWatchers = $this->requestAction('/projects/projects_watchers/most_watched/'.$numberOfProjects);
?>

<div id="ELEMENT_PROJECTS_MOST_WATCHED_<?php echo $instance ?>">
	<h3><?php echo $moduleTitle ?></h3>
	<ul>
    	<?php
		#debug($projectsWatchers);
        foreach ($projectsWatchers as $watchedProject) {
			
			echo '<li>'
			. '<a href="/projects/projects/view/' . $watchedProject['Project']['id'] . '">'
			. $watchedProject['Project']['name']
			. '</a>'
			. ' <small>(' . $watchedProject['Project']['watchercount'] .')</small>'
			. '</li>';
		}

		?>
    </ul>
</div>