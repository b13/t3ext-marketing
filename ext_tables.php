<?php
defined('TYPO3_MODE') or die();

// add the main module after the "file" main module
$newTbeModules = array();
foreach ($GLOBALS['TBE_MODULES'] as $k => $v) {
	$newTbeModules[$k] = $v;
	if ($k == 'file') {
		$newTbeModules['marketing'] = '';
	}
}
$GLOBALS['TBE_MODULES'] = $newTbeModules;
unset($newTbeModules);

$GLOBALS['TBE_MODULES']['_configuration']['marketing'] = array(
	'configuration' => array(
		'access' => 'user,group',
		'name' => 'marketing',
		'workspaces' => 'online,custom',
		'icon' => 'fa-line-chart',
	),
	'labels' => array(
		'll_ref' => 'LLL:EXT:marketing/Resources/Private/Language/module_marketing.xlf',
	)
);

$GLOBALS['TBE_STYLES']['skins']['marketing']['availableSpriteIcons'][] = 'fa-line-chart';


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
	'B13.Marketing',		// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'marketing',			// Main module
	'Redirects',	// Name of the module
	'top',				// Position of the module
	array(          // Allowed controller action combinations
		'RedirectAdministration' => 'overview,add,edit,update,remove'
	),
	array(			// Additional configuration
		'access'    => 'user,group',
		'icon'      => 'EXT:marketing/Resources/Public/Icons/repeat_64x64.png',
		'labels'    => 'LLL:EXT:marketing/Resources/Private/Language/module_redirect.xlf',
	)
);
