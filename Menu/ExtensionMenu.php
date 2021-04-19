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

namespace Krator\StreamModule\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Zikula\MenuModule\ExtensionMenu\ExtensionMenuInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;
use Zikula\UsersModule\Collector\AuthenticationMethodCollector;

class ExtensionMenu implements ExtensionMenuInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var PermissionApiInterface
     */
    private $permissionApi;

    /**
     * @var AuthenticationMethodCollector
     */
    private $collector;

    public function __construct(
        FactoryInterface $factory,
        PermissionApiInterface $permissionApi,
        AuthenticationMethodCollector $collector
    ) {
        $this->factory = $factory;
        $this->permissionApi = $permissionApi;
        $this->collector = $collector;
    }

    public function get(string $type = self::TYPE_ADMIN): ?ItemInterface
    {
        $method = 'get' . ucfirst(mb_strtolower($type));
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return null;
    }

    private function getAdmin(): ?ItemInterface
    {
        $menu = $this->factory->createItem('streamAdminMenu');
        if ($this->permissionApi->hasPermission('KratorStreamModule::', '::', ACCESS_ADMIN)) {
            
			$menu->addChild('Front End View', [
                'route' => 'kratorstreammodule_game_index',
            ])->setAttribute('icon', 'fas fa-list');

            $menu->addChild('Games', [
				'route' => 'kratorstreammodule_streamentity_index',
			])->setAttribute('icon', 'fas fa-plus');
			
			$menu->addChild('Modify Config', [
				'route' => 'kratorstreammodule_config_settings',
			])->setAttribute('icon', 'fas fa-wrench');

        }

        return 0 === $menu->count() ? null : $menu;
    }

    public function getBundleName(): string
    {
        return 'KratorStreamModule';
    }
}
