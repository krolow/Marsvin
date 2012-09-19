<?php
namespace Marsvin;

class ImportFactory
{
    
    /**
     * Load the given provider
     * 
     * @param  string $provider Provider name
     * @param  \Cilex\Application $container The dependency injection container
     * 
     * @return ProviderInterface Retrive one provider object
     */
    public static function load($provider, \Cilex\Application $container)
    {
        $class = self::normalizeClassName($provider);

        if (!class_exists($class)) {

            $message = "
                The given provider name %s seems to not exists in the provider folder!

                Please check if really exists the folder with the name %s
                and inside that folder also exists the class %s and this class 
                must implement the %sProviderInterface.php";

            throw new \InvalidArgumentException(
                sprintf(
                    $message,
                    $provider,
                    __DIR__ 
                        . DIRECTORY_SEPARATOR 
                        . 'Provider' 
                        . DIRECTORY_SEPARATOR
                        . 'Bookmaker'
                        . DIRECTORY_SEPARATOR 
                        . $provider 
                        . DIRECTORY_SEPARATOR,
                    $class . '.php',
                    __NAMESPACE__ . '\\Provider\\'
                )
            );
        }

        return new $class($container);
    }

    /**
     * Get the full class name with the namespace based in the provider received
     * 
     * @param  string $provider The provider name
     * 
     * @return string Namepsace to access the class
     */
    private static function normalizeClassName($provider)
    {
        $class = ucfirst($provider);

        return __NAMESPACE__ 
            . '\\' 
            . 'Provider\\Bookmaker\\'
            . $class 
            . '\\' 
            . $class
            . 'Provider';
    }

}