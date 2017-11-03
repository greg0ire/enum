<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Twig\Extension\AbstractExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (class_exists(AbstractExtension::class)) {
            $loader->load('twig.xml');
        }
    }
}
