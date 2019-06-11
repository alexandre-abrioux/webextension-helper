# webextension helper

Speed up the distribution of self-hosted Firefox webextensions

- provides a lightweight web service to serve your JSON update manifest ;
- ease the usage of [`web-ext`](https://github.com/mozilla/web-ext) via a simple docker image
to sign your webextension on [AMO](https://addons.mozilla.org/)

## Dependencies

This tool relies on `docker` and `docker-compose`.
See https://docs.docker.com/compose/install/

Some shortcuts are provided by a `Makefile`.
You will need `make` to use them, but the tool is not mandatory.

## Installation

- navigate to your webextension's project directory

```
cd /home/<username>/dev/webextension
```

- move all sources to a new subdirectory `src`.
If you already used the `web-ext` npm package in this directory before you should also move your add-on id file.

```
mkdir src
mv !(src) src
[ -f .web-extension-id ] && mv .web-extension-id src
```
- clone this repository as a submodule of the webextension

```
git submodule add git@github.com:alexandre-abrioux/webextension-helper.git helper
```

- copy `helper/.env.dist` to `helper/.env` and fill in your [Mozilla API credentials](https://addons.mozilla.org/en-US/developers/addon/api/key/).
You can find all the available options on the [web-ext reference page](https://developer.mozilla.org/en-US/docs/Mozilla/Add-ons/WebExtensions/web-ext_command_reference).

```
cp helper/.env.dist helper/.env
vim helper/.env
```

## Signing your Web-Extension

Simply run `make sign`.

## Updating Mozilla's `web-ext` Tool

To rebuild the `web-ext` docker image you can run `make update`.

## Enabling Auto-Updates

- configure your webextension's manifest file to target the `update.php` script
```
"applications": {
  "gecko": {
    "update_url": "https://webextension-helper.example.com/updates.php"
  }
}
```

- use the `docker-compose.yml` file to start the web service on your server

```
make up
```

## Makefile

Some shortcuts are configured in a `Makefile`. Use `make help` for more information.

- `make help`
- `make build`
- `make up`
- `make stop`
- `make down`
- `make restart`
- `make sign`
- `make update`
