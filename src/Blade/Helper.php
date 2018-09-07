<?php

namespace BhuVidya\BladeHelper\Blade;

use Blade;

/**
 * The Blade custom helper - implements the pull request on the laravel framework from here:
 *
 * https://github.com/laravel/framework/pull/24923
 *
 * I like this Blade helper because it provides a layer between the raw string expression passed to a custom
 * directive, and our custom directive, so it can now have properly spec'ed arguments without worrying about
 * having to parse the raw expression string each time.
 *
 * I also like custom directives because they focus code in one place (DRY), and they make templates
 * cleaner to view and write.
 */
class Helper
{
    protected $helpers = [];


    /**
     * Create a helper directive for a regular function.
     *
     * @param string $directiveName
     * @param string|callable $function
     * @param bool $shouldEcho
     * @return void
     */
    public function helper(string $directiveName, $function = null, bool $shouldEcho = true)
    {
        $echo = $shouldEcho ? 'echo ' : '';

        if (!is_string($function) && is_callable($function)) {
            $this->helpers[$directiveName] = $function;
            Blade::directive($directiveName, function($expression) use ($directiveName, $echo) {
                return "<?php {$echo}app(config('blade_helper.instance'))->getHelper('$directiveName', $expression); ?>";
            });
            return;
        }

        $functionName = $function ?? $directiveName;
        Blade::directive($directiveName, function($expression) use ($functionName, $echo) {
            return "<?php $echo$functionName($expression); ?>";
        });
    }

    /**
     * Get and execute a callback helper directive.
     *
     * @param string $name
     * @param mixed ...$arguments
     * @return mixed
     */
    public function getHelper(string $name, ...$arguments)
    {
        return $this->helpers[$name](...$arguments);
    }
}
