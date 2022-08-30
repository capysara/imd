<?php

namespace Drupal\Tests\drupaleasy_repositories\Kernel;

use Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginManager;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test description.
 *
 * @group drupaleasy_repositories
 */
class DrupaleasyRepositoriesManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['drupaleasy_repositories'];

  /**
   * The plugin manager.
   *
   * @var \Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginManager
   */
  protected DrupaleasyRepositoriesPluginManager $manager;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    // Instantiate the class we want. Instantiate thru the container so we don't
    // have to get dependencies of dependencies of dependencies.
    $this->manager = $this->container->get('plugin.manager.drupaleasy_repositories');
  }

  /**
   * Test creating an instance of the .yml Remote plugin.
   *
   * @test
   */
  public function testYmlRemoteInstance() {
    $example_instance = $this->manager->createInstance('yml_remote');
    // This getPluginDefinition means: read its annotation
    $plugin_def = $example_instance->getPluginDefinition();
    $this->assertInstanceOf('Drupal\drupaleasy_repositories\Plugin\DrupaleasyRepositories\YmlRemote', $example_instance);
    $this->assertInstanceOf('Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginBase', $example_instance);
    $this->assertArrayHasKey('label', $plugin_def);
    $this->assertTrue($plugin_def['label'] == 'Remote .yml file');
  }

}
