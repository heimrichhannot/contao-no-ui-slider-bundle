<?php

namespace HeimrichHannot\NoUiSliderBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Contao\ManagerPlugin\Config\ExtensionPluginInterface;
use HeimrichHannot\NoUiSliderBundle\ContaoNoUiSliderBundle;
use HeimrichHannot\UtilsBundle\Container\ContainerUtil;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ExtensionPluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        $loadAfter = [ContaoCoreBundle::class];

        if (class_exists('HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle')) {
            $loadAfter[] = 'HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle';
        }

        if (class_exists('HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle')) {
            $loadAfter[] = 'HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle';
        }

        return [
            BundleConfig::create(ContaoNoUiSliderBundle::class)->setLoadAfter($loadAfter)
        ];
    }

    public function getExtensionConfig($extensionName, array $extensionConfigs, ContainerBuilder $container)
    {
        $extensionConfigs = ContainerUtil::mergeConfigFile(
            'huh_encore',
            $extensionName,
            $extensionConfigs,
            __DIR__.'/../Resources/config/config_encore.yml'
        );

        return $extensionConfigs;
    }

    /**
     * Allows a plugin to load container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@ContaoNoUiSliderBundle/Resources/config/services.yml');
        $loader->load('@ContaoNoUiSliderBundle/Resources/config/listeners.yml');
    }
}