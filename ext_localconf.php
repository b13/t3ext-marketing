<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['B13\\Marketing'] = 'B13\\Marketing\\Hooks\\FrontendRedirectHook->checkForRedirect';