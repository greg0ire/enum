<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Compiler\TranslatorCompilerPass;
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
    protected $frameworkExtension;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setParameter('kernel.debug', true);
        $this->setParameter('kernel.root_dir', sys_get_temp_dir());
        $this->setParameter('kernel.project_dir', sys_get_temp_dir());
        $this->setParameter('kernel.bundles_metadata', []);
        $this->setParameter('kernel.container_class', Container::class);

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

    public function testLabelServiceHasTheTranslator()
    {
        $this->registerService('translator.logging.inner', \stdClass::class);
        $this->registerService('logger', \stdClass::class);
        $this->frameworkExtension->load(
            ['framework' => ['translator' => ['fallbacks' => ['en']]]],
            $this->container
        );
        $this->load();
        $this->compile();
        $compilerPass = new TranslatorCompilerPass();
        $compilerPass->process($this->container);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'greg0ire_enum.symfony.translator.get_label',
            0,
            new Reference('translator.default')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions(): array
    {
        return [new Greg0ireEnumExtension()];
    }
}
