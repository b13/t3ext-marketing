<?php
namespace B13\Marketing\Controller;

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
 * @package B13\Marketing
 */
class RedirectAdministrationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * instance of the repository for redirects
	 *
	 * @var \B13\Marketing\Domain\Repository\RedirectRepository
	 * @inject
	 */
	protected $redirectRepository;

	/**
	 * instance of the repository for domains
	 *
	 * @var \B13\Marketing\Domain\Repository\DomainRepository
	 * @inject
	 */
	protected $domainRepository;

	/**
	 * show current redirects
	 * @param int $selectedDomain
	 */
	public function overviewAction($selectedDomain = NULL) {
		$allDomains = $this->domainRepository->findAll();
		if ($selectedDomain) {
			$redirects = $this->redirectRepository->findAllByDomainrecord($selectedDomain);
		} else {
			$redirects = $this->redirectRepository->findAll();
		}
		$this->view->assign('allDomains', $allDomains);
		$this->view->assign('redirects', $redirects);
	}

	/**
	 * Adds a redirect
	 *
	 * @param string $url
	 * @param string $destination
	 * @param int $httpstatuscode
	 * @param int $domainrecord
	 */
	public function addAction($url, $destination, $httpstatuscode, $domainrecord = NULL) {

		$url = '/' . ltrim(trim($url), '/');
		if ($domainrecord) {
			$existingRecord = $this->redirectRepository->findByUrl($url, $domainrecord);
		} else {
			$existingRecord = $this->redirectRepository->findByUrl($url);
		}

		if ($existingRecord) {
			$this->addFlashMessage('Redirect "' . htmlspecialchars($url) . '" already exists.', 'Failure', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		} else {
			$this->redirectRepository->add($url, $destination, $httpstatuscode, $domainrecord);
			$this->addFlashMessage('Redirect "' . htmlspecialchars($url) . '" was added successfully.', 'Record added');
		}
		$this->redirect('overview');
	}

	/**
	 * removes an existing redirect
	 * @param int $redirect
	 */
	public function removeAction($redirect) {
		$redirectRecord = $this->redirectRepository->findByUid($redirect);
		$this->redirectRepository->remove($redirect);
		$this->addFlashMessage('Redirect "' . htmlspecialchars($redirectRecord['url']) . '" was successfully removed.', 'Record deleted');
		$this->redirect('overview');
	}
}