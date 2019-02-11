<?php
namespace mattmezza\logger;

/**
 * @author Matteo Merola <mattmezza@gmail.com>
 * @since  20190211 Initial creation.
 */
final class SysLogger implements Logger
{
    /**
     * @param string $message
     */
    public function debug(string $message)
    {
        syslog(LOG_DEBUG, $message);
    }

    /**
     * @param string $message
     */
    public function info(string $message)
    {
        syslog(LOG_INFO, $message);
    }

    /**
     * @param string $message
     */
    public function error(string $message)
    {
        syslog(LOG_ERR, $message);
    }
}
