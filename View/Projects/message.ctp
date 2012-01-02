<div class="messages view">
  <div id="navigation">
    <div id="n1" class="info-block">
      <div class="viewRow">
        <ul class="metaData">
          <li><span class="metaDataLabel"> <?php echo __('Subject: '); ?> </span><span class="metaDataDetail"><?php echo $message['Message']['title']; ?></span></li>
          <li><span class="metaDataLabel"> <?php echo __('From: '); ?> </span><span class="metaDataDetail"><?php echo $message['Sender']['username']; ?></span></li>
          <li><span class="metaDataLabel"> <?php echo __('To: '); ?> </span>
            <?php if(!empty($message['Recipient'])) : foreach ($message['Recipient'] as $recipient) : ?>
            <span class="metaDataDetail"><?php echo $recipient['full_name'].', '; ?></span>
            <?php endforeach; endif; ?>
          </li>
        </ul>
        <div class="recordData">
          <?php echo $message['Message']['body']; ?>
        </div>
      </div>
    </div>
    <!-- /info-block end -->
  </div>
<a name="comments"></a>
<div id="post-comments">
  <?php $this->CommentWidget->options(array('allowAnonymousComment' => false));?>
  <?php echo $this->CommentWidget->display();?> </div>

<?php 
// set the contextual menu items
$this->set('context_menu', array('menus' => array(
	array(
		'heading' => 'Projects',
		'items' => array(
			$this->Html->link(__('Add', true), array('action' => 'messages', $project['Project']['id']), array('class' => 'add')),
			$this->Html->link('Delete', array('plugin' => 'messages', 'controller' => 'messages', 'action' => 'delete', $message['Message']['id']), array(), "Are you sure you want to delete {$message['Message']['subject']}")
			)
		),
	)));
?>
</div>