<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "marketing".
 *
 * Auto generated 04-02-2013 17:46
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Marketing',
	'description' => 'Foundation for marketing-related functionality like analytics and redirects',
	'category' => 'be',
	'author' => 'Benni Mack',
	'author_email' => 'benni@typo3.org',
	'dependencies' => 'backend,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'state' => 'stable',
	'clearCacheOnLoad' => 1,
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-7.9.99',
			'extbase' => '',
			'fluid' => ''
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
