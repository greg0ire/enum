<?php

namespace Greg0ire\Enum\Bridge\Symfony\Bundle;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Compiler\TranslatorCompilerPass;
use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container
            ->addCompilerPass(new TranslatorCompilerPass())
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass(): string
    {
        return Greg0ireEnumExtension::class;
    }
}
