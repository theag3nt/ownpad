<?php
/**
 * Nextcloud - Ownpad
 *
 * This file is licensed under the Affero General Public License
 * version 3 or later. See the COPYING file.
 *
 * @author István Gazsi <istvan.gazsi@theag3nt.com>
 * @copyright István Gazsi <istvan.gazsi@theag3nt.com>, 2021
 */

namespace OCA\Ownpad\Migration;

use OCP\Migration\IRepairStep;
use OCP\IConfig;
use OCP\Migration\IOutput;

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
        return '0.6.17 introduces a new checkbox to enable/disable the use of filename suffixes in padIDs.';
    }

    public function run(IOutput $output) {
        $installedVersion = $this->config->getAppValue('ownpad', 'installed_version', '0.0.0');
        if(version_compare($installedVersion, '0.6.17', '<')) {
            $appConfig = \OC::$server->getConfig();

            $enabled = ($appConfig->getAppValue('ownpad', 'ownpad_suffix_filename_enable', '') === '') ? 'no' : 'yes';
            $appConfig->setAppValue('ownpad', 'ownpad_suffix_filename_enable', $enabled);
        }
    }

}
