<?php
/**
 * Base class
 */
class BaseAjax
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
    

    // TODO: register the api/ folder
    /**
     * Autoload app classes
     */
    static protected function autoloadClasses()
    {
        // echo $root = $_SERVER['DOCUMENT_ROOT'].'paginator/';
        spl_autoload_register(function ($class) {
            $root = $_SERVER['DOCUMENT_ROOT'] . 'paginator/';
            $dirs = array(
                $root.'classes/',
                $root.'api/',
                $root.'interface/'
            );

            foreach ($dirs as $dir) {
                // echo $dir.'----';
                // echo $dir. ' -- '. $class;
                if (file_exists($dir.$class.'.php')){
                    require_once($dir. $class . '.php');
                    // return;
                    // echo $dir . $class . '.php';
                }
            }
        });
        // echo 'triggererd';
    }
}