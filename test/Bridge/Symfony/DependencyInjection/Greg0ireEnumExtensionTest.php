<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Greg0ire\Enum\Bridge\Twig\Extension\EnumExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumExtensionTest extends AbstractExtensionTestCase
{
    private $frameworkExtension;

    protected function setUp()
    {
        parent::setUp();
        $this->setParameter('kernel.debug', true);
        $this->setParameter('kernel.root_dir', sys_get_temp_dir());
        $this->setParameter('kernel.bundles_metadata', []);

        // needed for legacy versions of symfony
        $this->setParameter('kernel.bundles', []);
        $this->setParameter('kernel.cache_dir', sys_get_temp_dir());

        $this->container->registerExtension($this->frameworkExtension = new FrameworkExtension());
    }

    public function testLoad()
    {
        $this->frameworkExtension->load(
            ['framework' => ['translator' => ['fallbacks' => ['en']]]],
            $this->container
        );
        $this->load();

        $this->assertContainerBuilderHasService(
            'greg0ire_enum.twig.extension.enum',
            EnumExtension::class
        );
    }

    public function testLoadWithoutATranslator()
    {
        $this->frameworkExtension->load(
            ['framework' => ['translator' => ['enabled' => false]]],
            $this->container
        );
        $this->load();

        $this->assertContainerBuilderHasService(
            'greg0ire_enum.twig.extension.enum',
            EnumExtension::class
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [new Greg0ireEnumExtension()];
    }
}
