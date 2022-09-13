<?php

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\IniConfig;

Configure::config('settings', new IniConfig());
Configure::load('config', 'settings');
