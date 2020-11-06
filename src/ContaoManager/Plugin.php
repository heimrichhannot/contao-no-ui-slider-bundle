<?php

namespace HeimrichHannot\NoUiSliderBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use HeimrichHannot\NoUiSliderBundle\ContaoNoUiSliderBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
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

    /**
     * Allows a plugin to load container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@ContaoNoUiSliderBundle/Resources/config/services.yml');
        if (class_exists('HeimrichHannot\EncoreBundle\HeimrichHannotContaoEncoreBundle')) {
            $loader->load('@ContaoNoUiSliderBundle/Resources/config/config_encore.yml');
        }
    }
}