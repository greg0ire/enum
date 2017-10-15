<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Greg0ire\Enum\Bridge\Twig\Extension\EnumExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
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

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new Greg0ireEnumExtension(),
        ];
    }
}
