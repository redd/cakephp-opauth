<?php
App::uses('AppModel', 'Model');

class StrategyExpand extends AppModel {
	public $belongsTo = array(
		'Opauth.Strategy'
	);
}
