<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        if (class_exists(\Twig_Extension::class)) {
            $loader->load('twig.xml');

            if (class_exists(Translator::class)) {
                $container->getDefinition('greg0ire_enum.twig.extension.enum')
                    ->addArgument(new Reference('translator.default'));
            }
        }
    }
}
