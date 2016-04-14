<?php namespace Excodus\TranslateExtended;

use Backend;
use System\Classes\PluginBase;
use URL;
/**
 * Translate Extended Plugin Information File
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
            'name'        => 'Translate Extended',
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

//    TODO: allow users to opt-in into extending |app twig filter
//    /**
//     * Lets extend the app filter.
//     * @return array
//     */
//    public function registerMarkupTags()
//    {
//        return [
//            'filters' => [
//                'app' => [$this, 'appFilter'],
//            ]
//        ];
//    }
//
//    /**
//     * Extends the classic app filter
//     * @param  string $url
//     * @return string
//     */
//    public function appFilter($url)
//    {
//        return URL::to(Translator::instance()->getLocale() . '/' . $url);
//    }
}
