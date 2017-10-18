<?php

namespace Greg0ire\Enum\Bridge\Symfony\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumExtension extends Extension implements PrependExtensionInterface
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

            if ($config['use_translator']) {
                $container->getDefinition('greg0ire_enum.twig.extension.enum')
                    ->addArgument(new Reference('translator.default'));
            }
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('framework');
        $translatorEnabled = false;
        foreach ($configs as $config) {
            // the last one should win
            if (isset($config['translator']['enabled'])) {
                $translatorEnabled = (bool) $config['translator']['enabled'];
            } elseif (isset($config['translator']['fallbacks'])) {
                $translatorEnabled = (bool) $config['translator']['fallbacks'];
            }
        }

        if (!$translatorEnabled) {
            $container->prependExtensionConfig($this->getAlias(), ['use_translator' => false]);
        }
    }
}
