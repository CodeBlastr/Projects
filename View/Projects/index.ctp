<div class="projects index">
<fieldset>
  <legend><?php echo $page_title_for_layout; ?>
  <?php echo $this->Html->link(__("Create a new project."), array('action' => 'add'), array('class' => 'button')); ?>
  </legend>
</fieldset>
<?php echo $this->Element('scaffolds/index', array('data' => $projects)); ?> 
</div>