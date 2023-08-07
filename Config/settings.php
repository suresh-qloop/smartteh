<?php

/**
 * System wide languages. These will be appearing in both frontend and backend.
 * Key must be 2-letter language code. Value will (usually) be used for display
 */
Configure::write('Languages.all', [
	'lv' => 'LV',
	'ru' => 'RU',
	'en' => 'EN',
	'es' => 'ES',
	'de' => 'DE',
]);

/**
 * Default language (2-letter language code)
 */
Configure::write('Languages.default', 'lv');
