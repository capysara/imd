<?php

namespace Drupal\drupaleasy_repositories\Plugin\DrupaleasyRepositories;

use Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginBase;
use Drupal\Component\Serialization\Yaml;

/**
 * Plugin implementation of the drupaleasy_repositories.
 *
 * @DrupaleasyRepositories(
 *   id = "yml_remote",
 *   label = @Translation("Remote .yml file"),
 *   description = @Translation("Remote .yml file that includes repository metadata.")
 * )
 */
class YmlRemote extends DrupaleasyRepositoriesPluginBase {

  /**
   * {@inheritdoc}
   */
  public function validate(string $uri): bool {
    // $pattern = '|^https?://[a-zA-Z0-9.\-]+/[a-zA-Z0-9_\-.%/]+\.ya?ml$|';
    // $pattern = '|https://imd.lndo.site/batman-repo.yml|';
    $pattern = '|https://imd.lndo.site/batman-repo.txt|';

    if (preg_match($pattern, $uri) === 1) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function validateHelpText(): string {
    return 'https://anything.anything/anything/anything.yml (or "http")';
  }

  /**
   * {@inheritdoc}
   */
  public function getRepo(string $uri): array {
    // My site doesn't agree that http://imd.lndo.site/batman-repo.yml exists.
    // With `file($uri)` I get a nice error and it doesn't allow me to submit.
    // Without it, I'm allowed to submit, but it still doesn't create the node.
    // If I manually create a node, then save my user (with no changes), the
    // Repository node gets deleted as expected.
    // `file_exists` gets rid of the php. `file` doesn't.
    // If I comment out the entire `validate` method, then I get the nice error
    // not the php warning.
    // Mike's note: File_exists doesn't work with files over http.
    // if (file_exists($uri)) {
    dump($uri); // "https://imd.lndo.site/batman-repo.yml"
    if (file($uri)) {
      if ($file_content = file_get_contents($uri)) {
        $repo_info = Yaml::decode($file_content);
        $machine_name = array_key_first($repo_info);
        $repo = reset($repo_info);
        return $this->mapToCommonFormat($machine_name, $repo['label'], $repo['description'], $repo['num_open_issues'], $uri);
      }
    }
    return [];
  }

}
