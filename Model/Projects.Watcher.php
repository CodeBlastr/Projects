<?php
class ProjectsWatcher extends ProjectsAppModel {

	var $name = 'ProjectsWatcher';
	var $validate = array(
		'contact_id' => array('numeric'),
	); 
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Project' => array(
			'className' => 'Projects.Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creator' => array(
			'className' => 'Creator',
			'foreignKey' => 'creator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modifier' => array(
			'className' => 'Modifier',
			'foreignKey' => 'modifier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	
/**
 * add 
 * The goal is to make the data gets inserted..1st instance is from workflow
 * Hence we are using transaction id to start everything
 * 
 * @todo		This model should have no mention of OrderItem or CatalogItem, it needs to be removed completely. 
 */
	function add($data) {
		$return = false;
		if (!empty($data)) {
			$this->create();

			$OrderTransaction = ClassRegistry::init('Orders.OrderTransaction');

			$ots = $OrderTransaction->find('first', array(
				'conditions' => "OrderTransaction.id = {$data['OrderTransaction']['id']}",
				'contain' => array() )
			);
			
			$OrderItem = ClassRegistry::init('Orders.OrderItem');

			$o_items = $OrderItem->find('all', array(
				'conditions' => array("OrderItem.customer_id = {$data['OrderTransaction']['customer_id']}",
									"OrderItem.status" => 'incart'),
				'contain' => array('CatalogItem.model', 'CatalogItem.foreign_key'))
			);

			$project_ids = (Set::extract($o_items, '{n}.CatalogItem.foreign_key'));
			$project_ids  = array_unique($project_ids);

			foreach($project_ids  as $project_id) {
				$watcher[] = array('user_id' => $data['Customer']['id'], 'project_id' => $project_id);
			}

			if ($this->saveAll($watcher)) {
				$return = true;
			}
		}

		return $return;
	}
	
}
?>