<?php
namespace B13\Marketing\Domain\Repository;

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
/**
 * working with domains
 * Class RedirectRepository
 * @package B13\Marketing\Domain\Repository
 */
class RedirectRepository {

	/**
	 * Fetch all redirects bound to a specific domain
	 *
	 * @param $domainUid
	 * @return array
	 */
	public function findAllByDomainrecord($domainUid) {
		return $this->getDatabaseConnection()->exec_SELECTgetRows('*', 'tx_marketing_redirect', 'deleted=0 AND domainrecord=' . (int)$domainUid);
	}

	/**
	 * Fetch all redirects for all domains
	 *
	 * @return array|NULL
	 */
	public function findAll() {
		return $this->getDatabaseConnection()->exec_SELECTgetRows('*', 'tx_marketing_redirect', 'deleted=0');
	}

	/**
	 * Search for an existing redirect
	 *
	 * @param int $uid
	 * @return array|NULL
	 */
	public function findByUid($uid) {
		return $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
			'*',
			'tx_marketing_redirect',
			'deleted=0 AND uid=' . (int)$uid
		);
	}

	/**
	 * Search for an existing redirect
	 *
	 * @param string $url
	 * @return array|NULL
	 */
	public function findByUrl($url) {
		return $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
			'*',
			'tx_marketing_redirect',
			'deleted=0 AND url=' . $this->getDatabaseConnection()->fullQuoteStr($url, 'tx_marketing_redirects')
		);
	}

	/**
	 *
	 * @param string $url
	 * @param int $domainUid
	 * @return array|NULL
	 */
	public function findByUrlAndDomainrecord($url, $domainUid = NULL) {
		return $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
			'*',
			'tx_marketing_redirect',
			'deleted=0 AND url=' . $this->getDatabaseConnection()->fullQuoteStr($url, 'tx_marketing_redirects') . ' AND domainrecord=' . (int)$domainUid
		);
	}

	/**
	 * Add a new redirect
	 *
	 * @param string $url
	 * @param string $destination
	 * @param string $httpstatuscode
	 * @param int $domainrecord
	 */
	public function add($url, $destination, $httpstatuscode, $domainrecord = 0) {
		$urlhash = \TYPO3\CMS\Core\Utility\GeneralUtility::md5int(strtolower($url));
		$this->getDatabaseConnection()->exec_INSERTquery(
			'tx_marketing_redirect',
			array(
				'createdon' => time(),
				'modifiedon' => time(),
				'url' => $url,
				'urlhash' => $urlhash,
				'destination' => $destination,
				'httpstatuscode' => $httpstatuscode,
				'domainrecord' => (int)$domainrecord
			)
		);
	}

	/**
	 * Deletes an existing redirect
	 *
	 * @param $uid
	 */
	public function remove($uid) {
		$this->getDatabaseConnection()->exec_DELETEquery('tx_marketing_redirect', 'uid=' . (int)$uid);
	}
	/**
	 * Returns the database connection
	 *
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}
}