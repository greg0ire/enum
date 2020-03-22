<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Twig\Extension\AbstractExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class TranslatorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (class_exists(AbstractExtension::class) && $container->hasDefinition('translator.default')) {
            $container->getDefinition('greg0ire_enum.symfony.translator.get_label')
                ->addArgument(new Reference('translator.default'));
        }
    }
}
