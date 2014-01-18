<?php
/**
 * Routing for Opauth
 */
Router::connect('/auth/callback', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'callback'));
Router::connect('/auth/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index'));
Router::connect('/opauth-complete/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'opauth_complete'));
Router::connect('/opauth-disconnect/*', array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'disconnect'));
