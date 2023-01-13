<?php
/**
 * Base class
 */
class Base
{
    private $rootPath;
    private $assetsPath;

    public function __construct()
    {
        self::autoloadClasses();
    }

    /**
     * 
     * Get our templates path directory
     * @var $template name of the template
     * @return string
     */
    public function getTemplatesPath(string $template = '')
    {
        $templateDir = basename('../templates');
        
        if(isset($template) && $template != ''){
            // Check if template exists
            $templateFile = $template . '.php';
            if(file_exists($templateDir .'/'. $templateFile)){
                return $templateDir . '/' . $templateFile;
            }
            // Todo: do we trigger error ? Default return if the template !exists
            return $templateDir;
        }
        return $templateDir;
    }

    public function getAssetsPath()
    {
        return 'assets';
    }
    

    /**
     * Autoload app classes
     */
    static protected function autoloadClasses()
    {
        spl_autoload_register(function ($class) {
            include($class . '.php');
        });
        // echo 'triggererd';
    }
}