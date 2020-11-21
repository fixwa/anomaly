<?php
namespace Fixwa\Anomaly;


use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Config
{
    public static $BASE_PATH = null;
    public static $MODULES = [];

    public static function init($configurations)
    {
        Config::$BASE_PATH = $configurations['BASE_PATH'];
        foreach($configurations as $key => $config) {
            if ($key === 'MODULES') {
                foreach ($config as $moduleName => $moduleConfig) {
                    if (is_string($moduleConfig)) {
                        $moduleName = $moduleConfig;
                    }
                    $bootstrapFile = Config::$BASE_PATH . '/' . $moduleName . '/bootstrap.php';
                    if (file_exists($bootstrapFile)) {
                        Config::$MODULES[$moduleName] = include $bootstrapFile;
                    }
                }
            }
        }
    }
}
