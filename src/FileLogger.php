<?php
namespace mattmezza\logger;

/**
 * @author Matteo Merola <mattmezza@gmail.com>
 * @since  20190211 Initial creation.
 */
final class FileLogger implements Logger
{
    /**
     * String constants.
     */
    const LOG_MESSAGE_FORMAT = '[%s %s] %s' . PHP_EOL;
    const LOG_TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    /**
     * String constants for log levels.
     */
    const LOG_LEVEL_DEBUG = 'DEBUG';
    const LOG_LEVEL_INFO = 'INFO';
    const LOG_LEVEL_ERROR = 'ERROR';

    /** @var string */
    protected $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param string $message
     */
    public function debug(string $message)
    {
        $this->log(self::LOG_LEVEL_DEBUG, $message);
    }

    /**
     * @param string $message
     */
    public function info(string $message)
    {
        $this->log(self::LOG_LEVEL_INFO, $message);
    }

    /**
     * @param string $message
     */
    public function error(string $message)
    {
        $this->log(self::LOG_LEVEL_ERROR, $message);
    }

    /**
     * @param string $level
     * @param string $message
     */
    private function log(string $level, string $message)
    {
        file_put_contents(
            $this->filePath,
            vsprintf(
                self::LOG_MESSAGE_FORMAT,
                [
                    $level,
                    date(self::LOG_TIMESTAMP_FORMAT),
                    $message
                ]
            ),
            FILE_APPEND
        );
    }
}
