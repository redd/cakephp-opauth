<?php
class RenameToStrategy extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'Rename OpauthSetting to Strategy tables';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'rename_table' => array(
				'opauth_settings' => 'strategies',
				'opauth_setting_expands' => 'strategy_expands'
			),
			'rename_field' => array(
				'strategy_expands' => array(
					'opauth_setting_id' => 'strategy_id'
				)
			),
			'create_field' => array(
				'strategies' => array(
					'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'after' => 'id'),
					'indexes' => array(
						'BY_USER_ID' => array('column' => 'user_id', 'unique' => 0)
					)
				)
			)
		),
		'down' => array(
			'rename_table' => array(
				'strategies' => 'opauth_settings',
				'strategy_expands' => 'opauth_setting_expands'
			),
			'rename_field' => array(
				'opauth_setting_expands' => array(
					'strategy_id' => 'opauth_setting_id'
				)
			),
			'drop_field' => array(
				'opauth_settings' => array(
					'user_id',
					'indexes' => array(
						'BY_USER_ID'
					)
				)
			)
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		return true;
	}
}
