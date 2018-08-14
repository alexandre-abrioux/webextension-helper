# webextension helper
Speed up the distribution of self-hosted webextensions in Firefox.

## <a name="dependencies"></a>Dependencies
This tool relies on web-ext to sign your webextension on [AMO](https://addons.mozilla.org/).
```
npm install --global web-ext
```
See https://github.com/mozilla/web-ext

## Installation

- navigate to the webextension directory
```
cd /home/<username>/dev/webextension
```
- move all sources to a new subdirectory `src`. If you already used web-ext in this directory before you should also move your add-on id file.
```
mkdir src
mv !(src) src
[ -f .web-extension-id ] && mv .web-extension-id src
```
- clone this repository as a submodule of the webextension
```
git submodule add git@github.com:alexandre-abrioux/webextension-helper.git helper
```
- install web-ext (see [Dependencies](#dependencies) section)
- copy `helper/.env.dist` to `helper/.env` and fill in your Mozilla API credentials. You will find them here:
https://addons.mozilla.org/en-US/developers/addon/api/key/
```
cp helper/.env.dist helper/.env
vim helper/.env
```
- (optional) extend `web-ext-config.js` with your own settings by creating a local configuration file `/home/<username>/.web-ext-config.js` as stated in the [web-ext documentation](https://developer.mozilla.org/en-US/docs/Mozilla/Add-ons/WebExtensions/Getting_started_with_web-ext#Automatic_discovery_of_configuration_files).
## Signing your Webextension

Simply run `helper/sign.sh`. You may need to fix the script permissions.
```
chmod +x helper/sign.sh
helper/sign.sh
```

## Enabling Auto-Updates

- make `helper/public` available on your web server
- use `helper/public/update.php` in the webextension's manifest file
```
"applications": {
  "gecko": {
    "update_url": "https://example.com/updates.php"
  }
}
```