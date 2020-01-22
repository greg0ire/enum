<?php

namespace Greg0ire\Enum\Tests\Bridge\Twig\Extension;

use Greg0ire\Enum\Bridge\Twig\Extension\EnumExtension;
use Greg0ire\Enum\Tests\Fixtures\FooEnum;
use Greg0ire\Enum\Tests\Fixtures\FooInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\TwigFilter;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class EnumExtensionTest extends TestCase
{
    /**
     * @var TranslatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $translator;

    /**
     * @var EnumExtension
     */
    private $extension;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->extension = new EnumExtension($this->translator);
    }

    public function testEnvironment()
    {
        $twig = new Environment($this->createMock(LoaderInterface::class));
        $twig->addExtension($this->extension);

        $this->assertInstanceOf(TwigFilter::class, $twig->getFilter('enum_label'));

        $this->assertTrue($twig->hasExtension(EnumExtension::class));
    }

    /**
     * @dataProvider getLabels
     */
    public function testLabel($value, $class, $classPrefix, $separator, $expectedResult)
    {
        $this->assertSame(
            $expectedResult,
            $this->extension->label($value, $class, false, $classPrefix, $separator)
        );
    }

    public function getLabels()
    {
        return [
            [FooInterface::CHUCK, FooEnum::class, false, null, 'chuck'],
            [FooInterface::CHUCK, FooEnum::class, true, null, 'greg0ire_enum_tests_fixtures_foo_enum_chuck'],
            [FooInterface::CHUCK, FooEnum::class, true, '.', 'greg0ire.enum.tests.fixtures.foo_enum.chuck'],
        ];
    }

    public function testLabelWithTranslator()
    {
        $this->translator->expects($this->once())
            ->method('trans')->with('greg0ire_enum_tests_fixtures_foo_enum_chuck', [], 'test');

        $this->assertSame(
            'greg0ire_enum_tests_fixtures_foo_enum_chuck',
            $this->extension->label(FooInterface::CHUCK, FooEnum::class, 'test'),
            'Without any available translation, the filter should just return the key.'
        );
    }

    public function testGetConstants()
    {
        $this->assertSame(
            [
                'GOD'    => 'Dieu',
                'CHUCK'  => 'Chuck Norris',
                'GUITRY' => 'Sacha Guitry',
            ],
            $this->extension->getConstants(FooEnum::class)
        );
    }

    public function testGetKeys()
    {
        $this->assertSame(
            [
                'GOD',
                'CHUCK',
                'GUITRY',
            ],
            $this->extension->getKeys(FooEnum::class)
        );
    }

    public function testGetClassPrefixedKeys()
    {
        $this->assertSame(
            [
                'greg0ire_enum_tests_fixtures_foo_enum_GOD',
                'greg0ire_enum_tests_fixtures_foo_enum_CHUCK',
                'greg0ire_enum_tests_fixtures_foo_enum_GUITRY',
            ],
            $this->extension->getClassPrefixedKeys(FooEnum::class)
        );
    }
}
