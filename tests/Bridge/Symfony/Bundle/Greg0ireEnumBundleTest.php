<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\Bundle;

use Greg0ire\Enum\Bridge\Symfony\Bundle\Greg0ireEnumBundle;
use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumBundleTest extends AbstractContainerBuilderTestCase
{
    /**
     * @var Greg0ireEnumBundle
     */
    private $bundle;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->bundle = new Greg0ireEnumBundle();
    }

    public function testBuild()
    {
        $this->bundle->build($this->container);
    }

    public function testGetContainerExtension()
    {
        $this->assertInstanceOf(Greg0ireEnumExtension::class, $this->bundle->getContainerExtension());
    }
}
