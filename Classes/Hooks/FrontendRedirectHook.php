<?php
namespace B13\Marketing\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

class FrontendRedirectHook {

	/**
	 * Look for redirects in the database
	 *
	 * @param array $parameters the parameters in use
	 * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $controller the main TSFE object
	 * @return void
	 */
	public function checkForRedirect($parameters, $controller) {
		$pathInfo = GeneralUtility::getIndpEnv('TYPO3_SITE_SCRIPT');
		$pathInfo = strtolower(trim($pathInfo));
		$pathInfo = '/' . $pathInfo;

		$hash = GeneralUtility::md5int($pathInfo);
		$url = $this->getDatabaseConnection()->fullQuoteStr($pathInfo, 'tx_marketing_redirect');

		$redirectRow = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
			'destination, httpstatuscode, uid',
			'tx_marketing_redirect',
			'urlhash=' . $hash . ' AND url=' . $url . ' AND (domainrecord=0 OR domainrecord IN (' .
				'SELECT uid FROM sys_domain WHERE domainName=' . $this->getDatabaseConnection()->fullQuoteStr(GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY'), 'sys_domain') .
				' AND redirectTo="" AND deleted=0)' .
			')',
			'',
			'domainrecord DESC'
		);

		if (is_array($redirectRow)) {
			// Update statistic information
			$updatedFields = array(
				'counter' => 'counter+1',
				'lasthiton' => time(),
				'lasthttpreferer' => GeneralUtility::getIndpEnv('HTTP_REFERER')
			);
			$this->getDatabaseConnection()->exec_UPDATEquery(
				'tx_marketing_redirect',
				'uid=' . (int)$redirectRow['uid'],
				$updatedFields,
				array('counter')
			);

			// Do the actual redirect
			header('HTTP/1.1 ' . (int)$redirectRow['httpstatuscode'] . ' TYPO3 Redirect');
			header('Location: ' . GeneralUtility::locationHeaderUrl($redirectRow['destination']));
			exit;
		}
	}

	/**
	 * returns an instance of TYPO3_DB
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}