<?php

namespace Drupal\drupaleasy_repositories\DrupaleasyRepositories;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for drupaleasy_repositories plugins.
 */
abstract class DrupaleasyRepositoriesPluginBase extends PluginBase implements DrupaleasyRepositoriesInterface {

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  /**
   * Default implementation to validate repository URLs.
   *
   * @param string $uri
   *   The URI to validate.
   *
   * @return bool
   *   Returns FALSE is not valid.
   */
  public function validate(string $uri): bool {
    // SCK - validator always returns FALSE as a safety measure. It forces
    // plugin authors (people who want to write a new plugin of our type) to
    // always have to write a validate method of their own.
    return FALSE;
  }

  /**
   * Build array of a single repository.
   *
   * @param string $full_name
   *   The full name of the repository.
   * @param string $label
   *   The short name of the repository.
   * @param string $description
   *   The description of the repository.
   * @param int $num_open_issues
   *   The number of open issues.
   * @param string $url
   *   The URI of the repository.
   *
   * @return array
   *   An array containing info about a single repository.
   */
  protected function mapToCommonFormat(string $full_name, string $label, string $description, int $num_open_issues, string $url): array {
    $repo_info[$full_name] = [
      'label' => $label,
      'description' => $description,
      'num_open_issues' => $num_open_issues,
      'source' => $this->getPluginId(),
      'url' => $url,
    ];
    return $repo_info;
  }

}
