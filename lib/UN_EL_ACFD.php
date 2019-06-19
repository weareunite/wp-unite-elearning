<?php

/**
 * ACF Dev wrapper and bootstrap
 *
 * @since 1.0.0
 */
class UN_EL_ACFD
{
    /**
     * Class initialization
     */
    public static function init()
    {
        add_action('after_setup_theme', [
            __CLASS__,
            'afterPluginsLoaded',
        ], 100);
    }

    /**
     * Hook to launch after plugins are loaded
     */
    public static function afterPluginsLoaded()
    {
        if (class_exists('ACFD') && ACFD::isActive()) {
            self::runAcfdScript();
        }
    }

    /**
     * Run scripts with ACF Dev library
     */
    public static function runAcfdScript()
    {

    }
}
