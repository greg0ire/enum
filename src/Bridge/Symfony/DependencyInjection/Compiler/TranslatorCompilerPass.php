<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class TranslatorCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (class_exists(\Twig_Extension::class) && $container->hasDefinition('translator.default')) {
            $container->getDefinition('greg0ire_enum.twig.extension.enum')
                ->addArgument(new Reference('translator.default'));
        }
    }
}
