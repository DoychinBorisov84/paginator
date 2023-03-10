<?php
namespace Paginator\Classes;

/**
 * Base class - Singleton Pattern
 */
class Base
{
    private static $instance;

    /**
     * Construct - private visibility to avoid creating instances outside our class
     */
    private function __construct()
    {
        self::autoloadClasses();
    }

    /**
     * Checks if we got instance of the class created with public visibility
     * 
     * @return self instance
     */
    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new Base();
        }
        
        return self::$instance;
    }

    /**
     * Get our templates path directory
     * 
     * @var $template name of the template
     * 
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
            
         return $templateDir;
        }
        return $templateDir;
    }

    public function getAssetsPath()
    {
        return 'assets';
    }

    public function getHome()
    {
        return '/paginator/index.php';
    }
    
    /**
     * Autoload app classes
     */
    static protected function autoloadClasses()
    {
        spl_autoload_register(function ($class) {
            $rootPath = $_SERVER['DOCUMENT_ROOT'] . 'paginator/';
            $dirs = array(
                $rootPath.'classes/',
                $rootPath.'api/',
                $rootPath.'classes/interfaces/'
            );

            foreach ($dirs as $dir) {
                if (file_exists($dir.$class.'.php')){
                    require_once($dir . $class . '.php');
                }else{
                    $namespaceAsArray = explode('\\', $class);
                    $theClass = end($namespaceAsArray) . '.php';
                    if( file_exists( $dir . $theClass ) ){
                        require_once($dir . $theClass);
                    }
                }
            }
        });
    }
}