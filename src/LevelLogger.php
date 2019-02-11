<?php
namespace mattmezza\logger;

use Exception;

/**
 * @author Matteo Merola <mattmezza@gmail.com>
 * @since  20190211 Initial creation.
 */
final class LevelLogger implements Logger
{
    /**
     * String constants for log levels.
     */
    const ENV_LOG = 'LOG_LEVEL';
    const ENV_LOG_STRATEGY = 'LOG_STRATEGY';
    const ENV_LOG_STRATEGY_FILE_PATH = 'LOG_FILE_PATH';
    const LOG_FILE_DEFAULT = '/var/log/logger.log';
    const LOG_STRATEGY_SYSLOG = 'SYSLOG';
    const LOG_STRATEGY_STDOUT = 'STDOUT';
    const LOG_STRATEGY_FILE = 'FILE';
    const LOG_LEVEL_DEBUG = 'DEBUG';
    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_ERROR = 'ERROR';

    /**
     * Error constant.
     */
    const ERROR_INVALID_LOG_LEVEL = 'Invalid log level "%s".';
    const ERROR_INVALID_LOG_STRATEGY = 'Invalid log strategy "%s".';

    /** @var Logger */
    protected $logger;

    /** @var string */
    protected $logLevel;

    /**
     */
    public function __construct()
    {
        $this->initializeLogger();
        $this->initializeLogLevel();
    }

    /**
     * @throws Exception
     */
    private function initializeLogger()
    {
        $logStrategy = getenv(self::ENV_LOG_STRATEGY) ?: self::LOG_STRATEGY_SYSLOG;

        switch ($logStrategy) {
            case self::LOG_STRATEGY_SYSLOG:
                $this->logger = new SysLogger();
                break;
            case self::LOG_STRATEGY_FILE:
                $this->logger = new FileLogger(getenv(self::ENV_LOG_STRATEGY_FILE_PATH) ?: self::LOG_FILE_DEFAULT);
                break;
            case self::LOG_STRATEGY_STDOUT:
                $this->logger = new StdOutLogger();
                break;
            default:
                throw new Exception(vsprintf(self::ERROR_INVALID_LOG_STRATEGY, [$logStrategy]));
        }
    }

    /**
     * @throws Exception
     */
    private function initializeLogLevel()
    {
        $logLevel = getenv(self::ENV_LOG) ?: self::LOG_LEVEL_ERROR;

        switch ($logLevel) {
            case self::LOG_LEVEL_INFO:
            case self::LOG_LEVEL_DEBUG:
            case self::LOG_LEVEL_ERROR:
                $this->logLevel = $logLevel;
                break;
            default:
                throw new Exception(vsprintf(self::ERROR_INVALID_LOG_LEVEL, [$logLevel]));
        }
    }

    /**
     * @param string $message
     */
    public function debug(string $message)
    {
        if ($this->logLevel === self::LOG_LEVEL_DEBUG ||
            $this->logLevel === self::LOG_LEVEL_INFO
        ) {
            $this->logger->debug($message);
        }
    }

    /**
     * @param string $message
     */
    public function info(string $message)
    {
        if ($this->logLevel === self::LOG_LEVEL_INFO) {
            $this->logger->info($message);
        }
    }

    /**
     * @param string $message
     */
    public function error(string $message)
    {
        $this->logger->error($message);
    }
}
