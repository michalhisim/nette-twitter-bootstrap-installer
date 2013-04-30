Nette Twitter Bootstrap Installer
=================================

Composer post-install helper for Twitter bootstrap into Nette

Inspired by https://github.com/sanpii/twitter-bootstrap-installer

## Instalation

    $ composer require 'michalhisim/nette-twitter-bootstrap-installer *@dev'

And append this configuration in `composer.json`:

    "scripts": {
        "post-install-cmd": "michalhisim\\NetteTwitterBootstrapInstaller\\Composer\\ScriptHandler::postInstall",
        "post-update-cmd": "michalhisim\\NetteTwitterBootstrapInstaller\\Composer\\ScriptHandler::postUpdate"
    },
    "extra": {
        "nette-web-dir": "www"
    }

## Added features
 - variable vendor-dir path
