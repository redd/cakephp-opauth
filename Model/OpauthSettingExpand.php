<?php
App::uses('AppModel', 'Model');

class OpauthSettingExpand extends AppModel {
	public $belongsTo = array(
		'Opauth.OpauthSetting'
	);
}
