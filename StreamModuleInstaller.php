<?php

declare(strict_types=1);

/*
 * This file is part of the Krator\StreamModule package.
 *
 * Copyright Krator.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krator\StreamModule;

use Zikula\ExtensionsModule\Installer\AbstractExtensionInstaller;
use Krator\StreamModule\Entity\StreamEntity;

class StreamModuleInstaller extends AbstractExtensionInstaller
{
    protected $entities = [
        StreamEntity::class,
    ];
	
	public function install(): bool
    {
        // create all tables from according entity definitions
		try {
            $this->schemaTool->create($this->entities);
        } catch (Exception $exception) {
            $this->addFlash('error', $this->trans('Doctrine Exception') . ': ' . $exception->getMessage());
            $this->logger->error('{app}: Could not update the database tables during the upgrade. Error details: {errorMessage}.', ['app' => 'KratorStreamModule', 'errorMessage' => $exception->getMessage()]);
    
            return false;
        }
		// set up all our vars with initial values
        $this->setVar('thumbBlockWidth', 50);
		$this->setVar('thumbBlockHeight', 50);
		$this->setVar('thumbStreamWidth', 260);
		$this->setVar('thumbStreamHeight', 180);
		$this->setVar('streamWidth', 1280);
		$this->setVar('streamHeight', 720);
		$this->setVar('clientId', '');
		$this->setVar('clientSecret', '');
		$this->setVar('appToken', '');
		$this->setVar('streamsBlock', 5);
		$this->setVar('favLang', 'es,en');
		
		return true;
    }

    public function upgrade(string $oldVersion): bool
    {
        return true;
    }

    public function uninstall(): bool
    {
        // remove tables
        try {
            $this->schemaTool->drop($this->entities);
        } catch (Exception $exception) {
            $this->addFlash('error', $this->trans('Doctrine Exception') . ': ' . $exception->getMessage());
            $this->logger->error('{app}: Could not remove the database tables during uninstallation. Error details: {errorMessage}.', ['app' => 'KratorStreamModule', 'errorMessage' => $exception->getMessage()]);
    
            return false;
        }
    
        // remove all module vars
        $this->delVars();
    
        // uninstallation successful
        return true;
    }
}
