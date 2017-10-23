<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection;

use Greg0ire\Enum\Bridge\Symfony\Form\Type\EnumType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

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
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (class_exists(\Twig_Extension::class)) {
            $loader->load('twig.xml');

            $container->getDefinition('greg0ire_enum.twig.extension.enum')
                ->replaceArgument(1, $config['translation_domain'])
                ->replaceArgument(2, $config['prefix_label_with_class'])
            ;
        }

        $loader->load('form.xml');
        $container->getDefinition(EnumType::class)
            ->replaceArgument(0, $config['prefix_label_with_class'])
        ;
    }
}
