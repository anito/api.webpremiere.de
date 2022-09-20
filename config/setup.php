<?php

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\IniConfig;

Configure::config('settings', new IniConfig());
Configure::load('config', 'settings');
Configure::write('DebugKit.safeTld', Configure::read('DebugKit.tld'));
