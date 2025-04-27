<?php

/**
 * Nextcloud - Ownpad
 *
 * This file is licensed under the Affero General Public License
 * version 3 or later. See the COPYING file.
 *
 * @author István Gazsi <istvan.gazsi@theag3nt.com>
 * @copyright István Gazsi <istvan.gazsi@theag3nt.com>, 2025
 */

namespace OCA\Ownpad\Migration;

use OCP\IConfig;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class ConfigSuffixFilenameEnable implements IRepairStep {

	/** @var IConfig */
	private $config;

	/**
	 * @param IConfig $config
	 */
	public function __construct(IConfig $config) {
		$this->config = $config;
	}

	public function getName() {
		return '0.13.0 introduces a new checkbox to enable/disable the use of filename suffixes in pad IDs.';
	}

	public function run(IOutput $output) {
		$installedVersion = $this->config->getAppValue('ownpad', 'installed_version', '0.0.0');
		if (version_compare($installedVersion, '0.13.0', '<')) {
			$enabled = ($this->config->getAppValue('ownpad', 'ownpad_etherpad_suffix_filename_enable', '') === '') ? 'no' : 'yes';
			$this->config->setAppValue('ownpad', 'ownpad_etherpad_suffix_filename_enable', $enabled);

			$normalize = ($this->config->getAppValue('ownpad', 'ownpad_etherpad_suffix_filename_normalize', '') === '') ? 'no' : 'yes';
			$this->config->setAppValue('ownpad', 'ownpad_etherpad_suffix_filename_normalize', $normalize);
		}
	}
}
