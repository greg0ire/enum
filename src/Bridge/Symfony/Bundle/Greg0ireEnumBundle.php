<?php

namespace Greg0ire\Enum\Bridge\Symfony\Bundle;

use Greg0ire\Enum\Bridge\Symfony\DependencyInjection\Greg0ireEnumExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Greg0ireEnumBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass()
    {
        return Greg0ireEnumExtension::class;
    }
}
