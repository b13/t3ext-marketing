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
 *
 * @package B13\Marketing\Domain\Repository
 */
class DomainRepository {

	/**
	 * Fetch all domains
	 *
	 * @return array|NULL
	 */
	public function findAll() {
		return $this->getDatabaseConnection()->exec_SELECTgetRows('*', 'sys_domain', 'hidden=0');
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