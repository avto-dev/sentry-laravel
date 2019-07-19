<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sentry DSN
    |--------------------------------------------------------------------------
    |
    | After you complete setting up a project in Sentry, you’ll be given a
    | value which we call a DSN, or Data Source Name. It looks a lot like a
    | standard URL, but it’s actually just a representation of the
    | configuration required by the Sentry SDKs.
    |
    | The DSN can be found in Sentry by navigating to
    | [Project Name] -> Project Settings -> Client Keys (DSN)
    |
    | Example: 'https://<key>:<secret>@sentry.io/<project>'
    |
    | Full documentation can be found here:
    | <https://docs.sentry.io/error-reporting/configuration/?platform=php>
    |
    */
    'dsn' => env('SENTRY_DSN', '---> PUT YOUR SENTRY DSN HERE <---'),

    /*
    |--------------------------------------------------------------------------
    | Server Name
    |--------------------------------------------------------------------------
    |
    | Can be used to supply a "server name". When provided, the name of the
    | server is sent along and persisted in the event. Note that for many
    | integrations the server name actually corresponds to the device
    | hostname even in situations where the machine is not actually a server.
    | Most SDKs will attempt to auto-discover this value
    |
    */
    'server_name' => env('SERVER_NAME', \gethostname()),

    /*
    |--------------------------------------------------------------------------
    | Release Hash
    |--------------------------------------------------------------------------
    |
    | Releases are used by Sentry to provide you with additional context when
    | determining the cause of an issue.
    |
    | With this package we use application version instead git sha hash, so,
    | you don't need to set this value manually.
    |
    | Example:
    | exec('git --git-dir ' . base_path('.git') . ' log --pretty="%h" -n1 HEAD')
    |
    | Documentation: <https://docs.sentry.io/learn/releases/>
    |
    */
    //'release' => env('APP_VERSION'),

    /*
    |--------------------------------------------------------------------------
    | Sample Rate
    |--------------------------------------------------------------------------
    |
    | Configures the sample rate as a percentage of events to be sent in the
    | range of 0.0 to 1.0. The default is 1.0 which means that 100% of events
    | are sent. If set to 0.1 only 10% of events will be sent. Events are
    | picked randomly.
    |
    */
    //'sample_rate' => 1.0,

    /*
    |--------------------------------------------------------------------------
    | Max Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | This variable controls the total amount of breadcrumbs that should be
    | captured. This defaults to 100.
    |
    */
    //'max_breadcrumbs' => 100,

    /*
    |--------------------------------------------------------------------------
    | Attach Stacktrace
    |--------------------------------------------------------------------------
    |
    | When enabled, stack traces are automatically attached to all messages
    | logged. Note that stack traces are always attached to exceptions but
    | when this is set stack traces are also sent with messages. This, for
    | instance, means that stack traces appear next to all log messages.
    |
    | It’s important to note that grouping in Sentry is different for events
    | with stack traces and without. This means that you will get new groups
    | as you enable or disable this flag for certain events.
    |
    | This feature is off by default.
    |
    */
    //'attach_stacktrace' => true,

    /*
    |--------------------------------------------------------------------------
    | Send Default PII
    |--------------------------------------------------------------------------
    |
    | If this flag is enabled, certain personally identifiable information is
    | added by active integrations. Without this flag they are never added to
    | the event, to begin with. If possible,  it’s recommended to turn on this
    | feature and use the server side PII stripping to remove the values
    | instead.
    |
    | Docs: <https://docs.sentry.io/platforms/php/laravel/#user-context>
    |
    */
    //'send_default_pii' => true,

    /*
    |--------------------------------------------------------------------------
    | Http Proxy
    |--------------------------------------------------------------------------
    |
    | When set a proxy can be configured that should be used for outbound
    | requests. This is also used for HTTPS requests unless a separate
    | https-proxy is configured. Note however that not all SDKs support
    | a separate HTTPS proxy. SDKs will attempt to default to the system-wide
    | configured proxy if possible. For instance, on unix systems, the
    | http_proxy environment variable will be picked up.
    |
    */
    //'http_proxy' => null,

];
