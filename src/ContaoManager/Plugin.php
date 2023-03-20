<?php

namespace HeimrichHannot\NoUiSliderBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use HeimrichHannot\NoUiSliderBundle\HeimrichHannotNoUiSliderBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        $loadAfter = [ContaoCoreBundle::class];

        if (class_exists('HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle')) {
            $loadAfter[] = 'HeimrichHannot\FilterBundle\HeimrichHannotContaoFilterBundle';
        }

        return [
            BundleConfig::create(HeimrichHannotNoUiSliderBundle::class)->setLoadAfter($loadAfter)
        ];
    }

    /**
     * Allows a plugin to load container configuration.
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig)
    {
        $loader->load('@HeimrichHannotNoUiSliderBundle/config/services.yaml');
    }
}