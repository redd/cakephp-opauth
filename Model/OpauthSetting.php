<?php
App::uses('AppModel', 'Model');

class OpauthSetting extends AppModel {
	public $actsAs = array(
		'Expandable.Expandable' => array(
			'with' => 'OpauthSettingExpand'
		)
	);

	public $hasMany = array(
		'OpauthSettingExpand' => array(
			'className' => 'Opauth.OpauthSettingExpand',
			'dependent' => true
		)
	);
}
