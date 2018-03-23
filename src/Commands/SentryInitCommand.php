<?php

namespace AvtoDev\Sentry\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use AvtoDev\AppVersion\Contracts\AppVersionManagerContract;

/**
 * Class SentryInitCommand.
 */
class SentryInitCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'sentry:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize sentry (make config, etc)';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var AppVersionManagerContract
     */
    protected $version;

    /**
     * SentryInitCommand constructor.
     *
     * @param Filesystem                $files
     * @param AppVersionManagerContract $manager
     */
    public function __construct(Filesystem $files, AppVersionManagerContract $manager)
    {
        parent::__construct();

        $this->files   = $files;
        $this->version = $manager;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->initializeConfigFile();
    }

    /**
     * Make config file initialization.
     *
     * @return int
     */
    protected function initializeConfigFile()
    {
        $configs_path   = $this->getConfigsPath();
        $default_config = $this->getDefaultConfig();

        $config = $this->files->exists($sentry_config_file_path = $configs_path . '/sentry.php')
            ? array_replace_recursive($default_config, (array) require $sentry_config_file_path)
            : $default_config;

        // Prepare stub content
        $stub = str_replace(
            [
                '{{dsn}}',
                '{{release}}',
                '{{breadcrumbs_sql_bindings}}',
                '{{user_context}}',
            ],
            [
                $config['dsn'],
                empty($release = $config['release'])
                    ? 'null'
                    : "'{$release}'",
                (bool) $config['breadcrumbs.sql_bindings']
                    ? 'true'
                    : 'false',
                (bool) $config['user_context']
                    ? 'true'
                    : 'false',
            ],
            $this->files->get(__DIR__ . '/stubs/sentry_config.stub')
        );

        // Make backup of exists config
        if ($this->files->exists($sentry_config_file_path)) {
            if ($this->files->exists($backup_file_path = sprintf('%s.bak', $sentry_config_file_path))) {
                if (! $this->option('force')) {
                    $confirmed = $this->confirm(
                        sprintf('Config backup file (%s) already exists. Overwrite it?', $backup_file_path)
                    );

                    if (! $confirmed) {
                        $this->comment('Command Cancelled!');

                        return 1;
                    }
                }

                if ($this->files->delete($backup_file_path)) {
                    $this->warn(sprintf('Backup of config file (%s) removed', $backup_file_path));
                }
            }

            $this->files->copy($sentry_config_file_path, $backup_file_path);
        }

        $this->files->put($sentry_config_file_path, $stub, true);

        $this->info(sprintf('Config file "%s" updated successfully', $sentry_config_file_path));

        return 0;
    }

    /**
     * Get the output directory path.
     *
     * @return array|string
     */
    protected function getConfigsPath()
    {
        return empty($passed_path = $this->option('configs-path'))
            ? config_path()
            : $passed_path;
    }

    /**
     * Returns default sentry config.
     *
     * @return mixed[]
     */
    protected function getDefaultConfig()
    {
        return [
            'dsn'                      => '',
            'release'                  => null,
            'breadcrumbs.sql_bindings' => true,
            'user_context'             => true,
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation (do not ask anything).'],
            ['configs-path', null, InputOption::VALUE_OPTIONAL, 'Path to the configs directory.'],
        ];
    }
}
