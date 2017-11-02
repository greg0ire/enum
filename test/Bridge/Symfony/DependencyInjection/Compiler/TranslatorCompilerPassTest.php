<?php

namespace Greg0ire\Enum\Tests\Bridge\Symfony\DependencyInjection\Compiler;

use Greg0ire\Enum\Tests\Fixtures\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * We have to make a kernel test case because the hasDefinition check didn't work on the extension class.
 */
final class TranslatorCompilerPassTest extends KernelTestCase
{
    public function testTwigExtensionHasTheTranslator()
    {
        static::bootKernel();

        static::assertAttributeInstanceOf(
            TranslatorInterface::class,
            'translator',
            self::$kernel->getContainer()->get('greg0ire_enum.twig.extension.enum')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass()
    {
        return AppKernel::class;
    }
}
