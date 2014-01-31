<?php
class OpauthController extends OpauthAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array(
		'Session'
	);

/**
 * Uses
 * @var array
 */
	public $uses = array(
		'Opauth.Strategy'
	);

/**
 * Constructor
 *
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->modelClass = null;
	}

/**
 * beforeFilter callback
 *
 * @return void
 */
	public function beforeFilter() {
		// Allow access to Opauth methods for users of AuthComponent
		if (is_object($this->Auth) && method_exists($this->Auth, 'allow')) {
			$this->Auth->allow();
		}

		// Disable Security for the plugin actions in case that Security Component is active
		if (is_object($this->Security)) {
			$this->Security->validatePost = false;
			$this->Security->csrfCheck = false;
		}
	}

/**
 * Handle Opauth response
 *
 * @return void
 */
	public function opauth_complete() {
		if (!$this->data['validated']) {
			return;
		}

		// Clearing cache
        Cache::clear();

		$data = $this->data['auth'];
		$strategy = $data['provider'];
		$auth = Configure::read(sprintf('Opauth.Strategy.%s', $strategy));
		foreach ($data['credentials'] as $key => $value) {
			$auth_keys = array_keys($auth);
			if (in_array($key, $auth_keys)) {
				$key .= '2';
			}
			$auth[$key] = $value;
		}

		// Writing into session
		if ($this->Session->check($strategy)) {
			$auth = Hash::merge($this->Session->read($strategy), $auth);
		}
		$this->Session->write($strategy, $auth);

		// Writing into db for later use
		$data = $this->Strategy->findByName($strategy);
		if ($data) {
			$this->Strategy->id = $data['Strategy']['id'];
		} else {
			$this->Strategy->create();
		}
		$auth['name'] = $strategy;
		$this->Strategy->save($auth);

		// Redirect to strategy url
		$redirect = Configure::read(sprintf('Opauth.Strategy.%s.redirect', $strategy));
		if ($redirect) {
			$this->Session->setFlash(__('Connection with %s successful', $strategy));
			return $this->redirect($redirect);
		}
		debug($this->data);
	}

/**
 * Disconnect / logout from Opauth strategy
 *
 * @return void
 */
	public function disconnect($strategy) {
		$strategy = Inflector::camelize($strategy);

		// Delete from session
		$this->Session->delete($strategy);

		// Delete cache files
		Cache::clear();

		// Delete from db
		$data = $this->Strategy->findByName($strategy);
		if ($data) {
			$this->Strategy->delete($data['Strategy']['id']);
		}

		// Redirect to strategy url
		$redirect = Configure::read(sprintf('Opauth.Strategy.%s.redirect', $strategy));
		if ($redirect) {
			$this->Session->setFlash(__('%s disconnected', $strategy));
			return $this->redirect($redirect);
		}
		debug(__('%s disconnected', $strategy));
	}
}
