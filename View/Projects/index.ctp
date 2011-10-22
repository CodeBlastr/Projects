
<fieldset>
  <legend>
  <h2>
    <?php  echo !empty($this->request->params['named']['archived']) ? __("Archived ") : __("Current "); echo __("Projects")?>
  </h2>
  <?php echo $this->Html->link(__("Create a new project."), array('action' => 'add'), array('class' => 'button')); ?>
  </legend>
</fieldset>
<?php echo $this->Element('scaffolds/index', array('data' => $projects)); ?> 