<?php

namespace michalhisim\NetteTwitterBootstrapInstaller\Composer;

use \Composer\Script\CommandEvent;

class ScriptHandler {

    static public function postInstall(CommandEvent $event) {
        self::installBootstrap($event);
    }

    static public function postUpdate(CommandEvent $event) {
        self::installBootstrap($event);
    }

    static private function installBootstrap(CommandEvent $event) {
        $event->getIO()->write('<info>Generating bootstrap assets</info>');

        $configOptions = self::getConfigOptions($event);
        $vendorDir = $configOptions['vendor-dir'];

        if (!is_dir($vendorDir)) {
            echo "The vendor-dir ($vendorDir) specified in composer.json was not found in " . getcwd() . ", can not build bootstrap file.\n";

            return;
        }

        $extraOptions = self::getExtraOptions($event);
        $webDir = $extraOptions['nette-web-dir'];

        if (!is_dir($webDir)) {
            echo "The nette-web-dir ($webDir) specified in composer.json was not found in " . getcwd() . ", can not build bootstrap file.\n";

            return;
        }

        $bootstrapDir = $vendorDir . "/twitter/bootstrap";

        self::createDirectory("$webDir/css/bootstrap");
        self::createDirectory("$webDir/js/bootstrap");
        self::createDirectory("$webDir/images");

        foreach (glob("$bootstrapDir/less/*.less") as $src) {
            $dst = "$webDir/css/bootstrap/" . basename($src);
            copy($src, $dst);
        }

        foreach (glob("$bootstrapDir/js/bootstrap*.js") as $src) {
            $dst = "$webDir/js/bootstrap/" . basename($src);
            copy($src, $dst);
        }

        foreach (glob("$bootstrapDir/img/*.png") as $src) {
            $dst = "$webDir/images/" . basename($src);
            copy($src, $dst);
        }
    }

    static private function createDirectory($name) {
        if (!is_dir($name)) {
            mkdir($name);
        }
    }

    static protected function getExtraOptions(CommandEvent $event) {
        $options = array_merge(array(
            'nette-web-dir' => 'www',
                ), $event->getComposer()->getPackage()->getExtra());

        return $options;
    }

    static protected function getConfigOptions(CommandEvent $event) {
        $allConfig = $event->getComposer()->getConfig()->all();
        
        $options = array_merge(array(
            'vendor-dir' => './li/bs',
                ), $allConfig['config']);
        
        return $options;
    }

}
