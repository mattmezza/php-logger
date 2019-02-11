php-logger
=====

[![Travis (.org)](https://img.shields.io/travis/mattmezza/php-logger.svg)](https://github.com/mattmezza/php-logger)

This package is a small utility for logging purposes. It allows you to quickly set up a logging system.

## Usage

The main component to use is `LevelLogger`. Just create a new instance and start logging.

```php
$log = new LevelLogger();

$log->info('DONE.');
$log->debug('I\'m here.');
$log->error($exception->getMessage());
```

There are `3` levels namely `info|debug|error` that come handy when switching environment `development|staging|production`.

The package comes with `3` logging strategies namely:

- `STDOUT` (default): it just `echo` the message (together with a timestamp and the log level)
- `SYSLOG`: calls the `syslog(...)` function and logs the message (using the syslog format) to the system log
- `FILE`: appends the log message (together with the timestamp and log level) to a file that you specify

#### How do you specify the parameters?

The package reads from `ENV` variables. The following variables are used:

- `LOG_LEVEL`: can be either `INFO|DEBUG|ERROR` and defaults to `ERROR` to be the least verbose. When the log level is `ERROR` all the `info` and `debug` messages will not be logged. When the log level is set to `DEBUG`, all the `info` messages will not be logged. When set to `INFO` instead, all of the messages will be logged;
- `LOG_STRATEGY`: can be either `STDOUT|SYSLOG|FILE` and defaults to `SYSLOG`. It sets the strategy. When the `FILE` strategy is chosen, please specify the file path by using the next described variable;
- `LOG_FILE_PATH`: must be a writable file path. It defaults to `/var/log/logger.log`;
 
## Development

You can add new loggers by implementing the `Logger` interface.

## Further development

- [ ] Would be nice to add a file rotate feature when logging to file.
