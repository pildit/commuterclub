<?php


class Config
{   
    private static $loaded = false;
    
    private static $configEntries = [];
    
    public static function load($environment)
    {
        $configFile = __DIR__.'/../config.php';
        
        if(!file_exists($configFile))
        {
            throw new FileNotFoundException($configFile);
        }
        
        if(!self::$loaded)
        {
            self::$configEntries = require $configFile;
        }
    }
    
    public static function get($path, $default = '')
    {
        $arr = self::$configEntries;
        $parts = explode('.', $path);
        
        foreach($parts as $part)
        {
            if(isset($arr[$part]))
            {
                $arr = $arr[$part];
            }
            
            else
            {
                return $default;
            }
        }
        
        return $arr;
    }
}