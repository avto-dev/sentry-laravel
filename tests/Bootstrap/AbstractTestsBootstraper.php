<?php

namespace AvtoDev\Sentry\Tests\Bootstrap;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use AvtoDev\Sentry\Tests\Traits\CreatesApplicationTrait;

/**
 * Class AbstractTestsBootstraper.
 */
abstract class AbstractTestsBootstraper
{
    use CreatesApplicationTrait;

    /**
     * Prefix for 'magic' bootstrap methods.
     */
    const MAGIC_METHODS_PREFIX = 'boot';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->app = $this->createApplication(null);

        $this->files = new Filesystem;

        // Перебираем все имена методов собственного класса
        foreach (get_class_methods(static::class) as $method_name) {
            // Если метод начинается с подстроки 'boot'
            if (Str::startsWith($method_name, static::MAGIC_METHODS_PREFIX)) {
                // То вызываем метод, передавая ему на вход массив коллекций (хотя передавать не обязательно)
                if (call_user_func_array([$this, $method_name], []) !== true) {
                    throw new Exception(sprintf(
                        'Bootstrap method "%s" has non-true result. So, we cannot start tests for this reason',
                        $method_name
                    ));
                }
            }
        }

        $this->log(null);
    }

    /**
     * Show "styled" console message.
     *
     * @param string|null $message
     * @param string      $style
     */
    protected function log($message = null, $style = 'info')
    {
        /** @var ConsoleOutput|null $output */
        static $output = null;

        if (! ($output instanceof ConsoleOutput)) {
            $output = $this->app->make(ConsoleOutput::class);
        }

        $output->writeln(empty($message)
            ? ''
            : sprintf('<%1$s>> Bootstrap:</%1$s> <%2$s>%3$s</%2$s>', 'comment', $style, $message)
        );
    }
}
