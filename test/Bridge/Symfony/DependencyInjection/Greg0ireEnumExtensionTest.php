<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Greg0ire\Enum\Bridge\Twig\Extension\EnumExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumExtensionTest extends AbstractExtensionTestCase
{
    public function testLoad()
    {
        $this->load();

        $this->assertContainerBuilderHasService(
            'greg0ire_enum.twig.extension.enum',
            EnumExtension::class
        );

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'greg0ire_enum.twig.extension.enum',
            0,
            new Reference('translator.default')
        );
    }

    public function prependDataProvider()
    {
        return [
            'translator disabled' => [
                ['enabled' => false],
                [['use_translator' => false]],
            ],
            'translator enabled' => [
                ['enabled' => true],
                [],
            ],
            'translator fallback' => [
                ['fallbacks' => ['en']],
                [],
            ],
        ];
    }

    /**
     * @dataProvider prependDataProvider
     */
    public function testPrepend($translatorConfig, $expectedConfigs)
    {
        $this->setParameter('kernel.debug', true);
        $this->setParameter('kernel.root_dir', sys_get_temp_dir());
        $this->setParameter('kernel.bundles_metadata', []);

        // needed for legacy versions of symfony
        $this->setParameter('kernel.bundles', []);
        $this->setParameter('kernel.cache_dir', sys_get_temp_dir());

        $this->container->registerExtension(new FrameworkExtension());
        $this->container->loadFromExtension(
            'framework',
            ['translator' => $translatorConfig]
        );
        $this->container->getExtension('greg0ire_enum')->prepend($this->container);
        $this->assertSame(
            $expectedConfigs,
            $this->container->getExtensionConfig('greg0ire_enum')
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
