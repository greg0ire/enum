<?php

namespace Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

/**
 * @author Marcin Klimek <marcin.r.k@o2.pl>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testTranslatorIsUsedByDefault()
    {
        $this->assertProcessedConfigurationEquals([], ['use_translator' => true]);
    }

    public function testLastConfigurationHasPriority()
    {
        $this->assertProcessedConfigurationEquals([
            ['use_translator' => false],
            ['use_translator' => true],
        ], ['use_translator' => true]);
    }
}
