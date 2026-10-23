<?php

declare(strict_types=1);

namespace Select2VanillaBundle\Tests;

use PHPUnit\Framework\TestCase;
use Select2VanillaBundle\DependencyInjection\Select2VanillaExtension;
use Select2VanillaBundle\Select2VanillaBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class Select2VanillaBundleTest extends TestCase
{
    public function testBundleUsesModernPublicAndTemplateDirectories(): void
    {
        $bundle = new Select2VanillaBundle();
        $path = $bundle->getPath();

        self::assertDirectoryExists($path.'/public');
        self::assertFileExists($path.'/public/css/select2vanilla.css');
        self::assertFileExists($path.'/public/js/select2vanilla.js');
        self::assertFileExists($path.'/public/js/select2-vanilla-init.js');
        self::assertFileExists($path.'/templates/Form/fields.html.twig');
    }

    public function testVendoredJavaScriptIsABrowserScript(): void
    {
        $js = (string) file_get_contents(dirname(__DIR__).'/public/js/select2vanilla.js');

        self::assertStringNotContainsString('export default', $js);
        self::assertStringContainsString('window.Select2Vanilla = Select2Vanilla;', $js);
    }

    public function testExtensionRegistersTheCorrectAssetPaths(): void
    {
        $bundlePath = dirname(__DIR__);
        $container = new ContainerBuilder();

        (new Select2VanillaExtension())->load([[]], $container);

        self::assertSame($bundlePath.'/public', $container->getParameter('select2_vanilla.asset_path'));
        self::assertSame($bundlePath.'/public/css/select2vanilla.css', $container->getParameter('select2_vanilla.css_path'));
        self::assertSame($bundlePath.'/public/js/select2vanilla.js', $container->getParameter('select2_vanilla.js_path'));
        self::assertSame($bundlePath.'/public/js/select2-vanilla-init.js', $container->getParameter('select2_vanilla.init_js_path'));
    }
}
