<?php namespace Excodus\TranslateRedirector;

use Backend;
use System\Classes\PluginBase;

/**
 * Translate-redirector Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Translate Redirector',
            'description' => 'Extends behavior of the default Translate Plugin',
            'author'      => 'Excodus',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Excodus\TranslateRedirector\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'excodus.translate-redirector.some_permission' => [
                'tab' => 'Translate-redirector',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'translate-redirector' => [
                'label'       => 'translate-redirector',
                'url'         => Backend::url('excodus/translate-redirector/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['excodus.translate-redirector.*'],
                'order'       => 500,
            ],
        ];
    }

}
