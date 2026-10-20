<?php

namespace Select2VanillaBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Select2VanillaBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration(
            $configuration,
            [[]]
        );

        self::assertSame('×', $config['remove_icon_html']);
        self::assertSame('Choisir ou saisir', $config['placeholder']);
        self::assertFalse($config['multiple']);
    }

    public function testCustomConfiguration(): void
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration(
            $configuration,
            [
                [
                    'remove_icon_html' => '<i class="fa fa-times"></i>',
                    'placeholder' => 'Sélectionner...',
                    'multiple' => true,
                ],
            ]
        );

        self::assertSame('<i class="fa fa-times"></i>', $config['remove_icon_html']);
        self::assertSame('Sélectionner...', $config['placeholder']);
        self::assertTrue($config['multiple']);
    }
}
