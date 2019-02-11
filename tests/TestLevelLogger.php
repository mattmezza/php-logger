<?php
namespace mattmezza\logger\test;

use mattmezza\logger\LevelLogger;
use PHPUnit\Framework\TestCase;

/**
 * @author Matteo Merola <mattmezza@gmail.com>
 * @since  20190211 Initial creation.
 */
class TestLevelLogger extends TestCase
{
    /**
     * Used to call the putenv function.
     */
    const ENV_FORMAT = '%s=%s';

    /**
     * The filename of the log file.
     */
    const LOG_FILE_PATH = __DIR__ . '/log.log';

    /**
     * Used to test that the log message has been added.
     */
    const TEST_LOG_MESSAGE = 'merola.co';

    /**
     */
    public function testLogStdOut()
    {
        $this->putenv(LevelLogger::ENV_LOG, LevelLogger::LOG_LEVEL_INFO);
        $this->putenv(LevelLogger::ENV_LOG_STRATEGY, LevelLogger::LOG_STRATEGY_STDOUT);
        $log = new LevelLogger();
        ob_start();
        $log->error(self::TEST_LOG_MESSAGE);
        $output = ob_get_clean();
        static::assertContains(self::TEST_LOG_MESSAGE, $output);
    }

    /**
     * @depends testLogStdOut
     */
    public function testLogFile()
    {
        $this->putenv(LevelLogger::ENV_LOG_STRATEGY, LevelLogger::LOG_STRATEGY_FILE);
        $this->putenv(LevelLogger::ENV_LOG_STRATEGY_FILE_PATH, self::LOG_FILE_PATH);
        $log = new LevelLogger();
        $log->error(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);
    }

    /**
     * @depends testLogFile
     */
    public function testLogDebug()
    {
        $this->putenv(LevelLogger::ENV_LOG, LevelLogger::LOG_LEVEL_DEBUG);
        $log = new LevelLogger();
        $log->info(self::TEST_LOG_MESSAGE);
        static::assertFileNotExists(self::LOG_FILE_PATH);

        $log->debug(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);

        $log->error(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);
    }

    /**
     * @depends testLogDebug
     */
    public function testLogInfo()
    {
        $this->putenv(LevelLogger::ENV_LOG, LevelLogger::LOG_LEVEL_INFO);
        $log = new LevelLogger();
        $log->info(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);

        $log->debug(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);

        $log->error(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);
    }

    /**
     * @depends testLogInfo
     */
    public function testLogError()
    {
        $this->putenv(LevelLogger::ENV_LOG, LevelLogger::LOG_LEVEL_ERROR);
        $log = new LevelLogger();
        $log->info(self::TEST_LOG_MESSAGE);
        static::assertFileNotExists(self::LOG_FILE_PATH);

        $log->debug(self::TEST_LOG_MESSAGE);
        static::assertFileNotExists(self::LOG_FILE_PATH);

        $log->error(self::TEST_LOG_MESSAGE);
        static::assertContains(self::TEST_LOG_MESSAGE, file_get_contents(self::LOG_FILE_PATH));
        unlink(self::LOG_FILE_PATH);
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function putenv(string $key, string $value)
    {
        putenv(vsprintf(self::ENV_FORMAT, [$key, $value]));
    }
}
