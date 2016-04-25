<?php namespace Excodus\TranslateExtended\Components;

use Cms\Classes\ComponentBase;
use RainLab\Translate\Models\Locale as LocaleModel;
use RainLab\Translate\Classes\Translator;

class ExtendedLocalePicker extends ComponentBase
{
    private $translator;

    public $locales;
    public $activeLocale;

    public function componentDetails()
    {
        return [
            'name'        => 'ExtendedLocalePicker Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function init()
    {
        $this->translator = Translator::instance();
    }

    public function onRun()
    {
        $this->page['activeLocale'] = $this->activeLocale = $this->translator->getLocale();
        $this->page['locales'] = $this->locales = LocaleModel::listEnabled();
        $currentPath = $this->getRouter()->getUrl();
        if($currentPath[0] != '/') {
            $currentPath = '/' . $currentPath;
        }
        $this->page['currentPath'] = $currentPath;
    }
}