<?php
/**
 * Created by PhpStorm.
 * User: r
 * Date: 13.04.16
 * Time: 16:12
 */

use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;
use Session;

App::before(function($request) {
    $translator = Translator::instance();
    if (!$translator->isConfigured())
        return;

    $locale = Request::segment(1);

    /*
     * Behavior when changing locale from the locale picker; post('locale') has priority over $locale,
     * because Request still have old locale in the URL, hence $locale is outdated and User sends new locale in the POST
     * TODO: hook the translate plugin's onSwitchLocale ajax handler instead of checking on post
     */
    if (post('locale') && $locale != post('locale')) {
        $translator->setLocale(post('locale'));
    }
    /*
     * Behavior when there is no locale in the Request URL, first check in session and then try to match with default browser language
     */
    if (!$locale || !Locale::isValid($locale)) {
        $localeSession = Session::get($translator::SESSION_LOCALE);
        if ($localeSession) {
            $translator->setLocale($localeSession);
        } else {
            // get the list of browser languages
            $accepted = parseLanguageList($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $available = Locale::listEnabled();
            // match against languages enabled in Translate plugin
            // TODO: allow october backend users to create their own mappings to the locale short codes
            $matches = findMatches($accepted, $available);
            // get the first match and save if not empty
            if (!empty($matches)) {
                $match = array_values($matches)[0];
                $translator->setLocale($match);
            }
        }
    }

    $locale = $translator->getLocale();

    if ($translator->setLocale($locale) === false) {
        $translator->setLocale($translator->getDefaultLocale());
    }

    // TODO: allow users to opt-in to route redirecting and leave only browser language detection
    Route::group(['prefix' => $locale], function() {
        Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
    });

    Route::any($locale, 'Cms\Classes\CmsController@run');

    Event::listen('cms.route', function() use ($locale) {
        Route::group(['prefix' => $locale], function() {
            Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
        });
    });

    Route::get('/', function() use ($locale) {
        return redirect($locale);
    });
});

// browser language parser based on Gumbo's answer
// http://stackoverflow.com/a/3771447/3704886

// parse list of comma separated language tags and sort it by the quality value
function parseLanguageList($languageList) {
    if (is_null($languageList)) {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return array();
        }
        $languageList = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }
    $languages = array();
    $languageRanges = explode(',', trim($languageList));
    foreach ($languageRanges as $languageRange) {
        if (preg_match('/(\*|[a-zA-Z0-9]{1,8}(?:-[a-zA-Z0-9]{1,8})*)(?:\s*;\s*q\s*=\s*(0(?:\.\d{0,3})|1(?:\.0{0,3})))?/', trim($languageRange), $match)) {
            if (!isset($match[2])) {
                $match[2] = '1.0';
            } else {
                $match[2] = (string) floatval($match[2]);
            }
            if (!isset($languages[$match[2]])) {
                $languages[$match[2]] = strtolower($match[1]);
            }
        }
    }
    krsort($languages);
    return $languages;
}

// compare two parsed arrays of language tags and find the matches
function findMatches($accepted, $available) {
    $matches = array();
    $any = false;
    foreach ($accepted as $acceptedQuality => $acceptedValue) {
        $acceptedQuality = floatval($acceptedQuality);
        if ($acceptedQuality === 0.0) continue;
        foreach ($available as $key => $value) {
            if ($acceptedValue === '*') {
                $any = true;
            }
            $matchingGrade = matchLanguage($acceptedValue, $key);
            if ($matchingGrade > 0) {
                $q = (string) ($acceptedQuality * $matchingGrade);
                if (!in_array($q, $matches)) {
                    $matches[$q] = $key;
                }
            }
        }
    }
    if (count($matches) === 0 && $any) {
        $matches = $available;
    }
    krsort($matches);
    return $matches;
}

// compare two language tags and distinguish the degree of matching
// edit: actually matching "en-us" with "en" will always return "1"
function matchLanguage($a, $b) {
    $a = explode('-', $a);
    $b = explode('-', $b);
    for ($i=0, $n=min(count($a), count($b)); $i<$n; $i++) {
        if ($a[$i] !== $b[$i]) break;
    }
//    return $i === 0 ? 0 : (float) $i / count($a);
    return $i;
}
