# Translate Extended
This plugins extends default behavior of the Rainlab's Tranlsate plugin (http://octobercms.com/plugin/rainlab-translate) with following features:
 * detect browser language
 * display (and save into session) most preferred browser language instead of the default one
 * redirect all routes with proper locale prefix

# Usage
The Translate Plugin have two scenarios of displaying translated content:

 * `http://website/lang/` will display the site in the language with 'lang' short code.
 * `http://website/` will display the site in the default language unless the user chooses preferred language
 
After installing the Translate Extended, when you visit home page URL:
 * plugin will try to guess most preferred user language (from browser settings) and match it with the enabled translations Rainlab's Tranlsate plugin
 * if match is found, this preference will be saved into user session and displayed immediately 
 * if there is no match, website will be displayed in default language (from the Rainlab's Tranlsate plugin settings)
 * route will be automatically prefixed with proper language shortcode
 
After you change the route, it will be automatically prefixed with chosen language

If you manually enter the language URI in the address bar it will be saved in the user session and displayed immediately 
 
# Language short codes
In order to work property Translate Extended needs correct language codes to be set in the Rainlab's Tranlsate plugin.
Language codes need to be identical with the ISO 639 Language Codes that are transmitted in the HTTP header "HTTP_ACCEPT_LANGUAGE".
http://www.metamodpro.com/browser-language-codes