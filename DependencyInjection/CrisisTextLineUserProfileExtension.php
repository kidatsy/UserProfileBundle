<?php

namespace CrisisTextLine\UserProfileBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CrisisTextLineUserProfileExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['roles_names'] as $key => $param) {
            $config['roles_names'][$key] = $param['name'];
        }
        $container->setParameter('crisistextline.user_profile.roles_names', $config['roles_names']);
        $container->setParameter('crisistextline.user_profile.test_admin_email', $config['test_admin_email']);

        foreach ($config['services'] as $key => $service) {
            $container->setParameter('crisistextline.user_profile.' . $key, $service);
        }
        $container->setParameter('crisistextline.user_profile.update_interval', $config['series_intervals']['update']);
        $container->setParameter('crisistextline.user_profile.reporting_intervals', $config['series_intervals']['reporting']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
