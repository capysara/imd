<?php

namespace Drupal\drupaleasy_repositories;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginManager;

/**
 * Service description.
 */
class DrupaleasyRepositoriesService {

  /**
   * The plugin.manager.drupaleasy_repositories service.
   *
   * @var \Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginManager
   */
  protected DrupaleasyRepositoriesPluginManager $pluginManagerDrupaleasyRepositories;

  /**
   * The config.factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * DrupaleasyRepositoriesService constructor.
   *
   * @param \Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginManager $drupaleasy_repositories_plugin_manager
   *   The plugin.manager.drupaleasy_repositories service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config.factory service.
   */
  public function __construct(DrupaleasyRepositoriesPluginManager $drupaleasy_repositories_plugin_manager, ConfigFactoryInterface $config_factory) {
    // These two^ are required in the services.yml arguments.
    // These are 2 services that have been injected into this service.
    $this->pluginManagerDrupaleasyRepositories = $drupaleasy_repositories_plugin_manager;
    $this->configFactory = $config_factory;
  }

  /**
   * Method description.
   */
  public function getValidateHelpText() {

  }

}
