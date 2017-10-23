<?php

namespace Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;

/**
 * @author Marcin Klimek <marcin.r.k@o2.pl>
 */
class ConfigurationTest extends AbstractConfigurationTestCase
{
    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testDefault()
    {
        $this->assertProcessedConfigurationEquals([], [
            'translation_domain' => null,
            'prefix_label_with_class' => null,
        ]);
    }
}
