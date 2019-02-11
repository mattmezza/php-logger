<?php
namespace mattmezza\logger;

/**
 * @author Matteo Merola <mattmezza@gmail.com>
 * @since  20190211 Initial creation.
 */
interface Logger
{
    /**
     * @param string $message
     */
    public function debug(string $message);

    /**
     * @param string $message
     */
    public function info(string $message);

    /**
     * @param string $message
     */
    public function error(string $message);
}
