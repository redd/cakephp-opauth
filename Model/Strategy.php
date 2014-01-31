<?php
App::uses('AppModel', 'Model');

class Strategy extends AppModel {
	public $actsAs = array(
		'Expandable.Expandable' => array(
			'with' => 'StrategyExpand'
		)
	);

	public $hasMany = array(
		'StrategyExpand' => array(
			'className' => 'Opauth.StrategyExpand',
			'dependent' => true
		)
	);
}
