<?php 
   # $this->set('documentData', array('xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));
	if (!isset($documentData)) {
        $documentData = array();
    }
	
    $this->set('channelData', array(
        'title' => __("Most Recent Messages", true),
        'link' => $this->Html->url('/', true),
        'description' => __("The most recent messages.", true),
        'language' => 'en-us'));
?>
<?php 

    foreach ($messages as $message) {
        $time = strtotime($message['Message']['created']);
        $link = array(
			'plugin' => 'projects',
            'controller' => 'projects',
            'action' => 'message',
            $message['Message']['id']);
        // You should import Sanitize
        App::import('Sanitize');
        // This is the part where we clean the body text for output as the description 
        // of the rss item, this needs to have only text to make sure the feed validates
        $bodyText = preg_replace('=\(.*?\)=is', '', $message['Message']['body']);
        $bodyText = $this->Text->stripLinks($bodyText);
        $bodyText = Sanitize::stripAll($bodyText);
        $bodyText = $this->Text->truncate($bodyText, 400, array(
            'ending' => '...',
            'exact'  => true,
            'html'   => true,
        ));

        #echo $bodyText;
        echo  $this->Rss->item(array(), array(
            'title' => $message['Message']['title'],
            'link' => $link,
            'guid' => array('url' => $link, 'isPermaLink' => 'true'),
            'description' =>  $bodyText,
            'pubDate' => $time));
    }
?>