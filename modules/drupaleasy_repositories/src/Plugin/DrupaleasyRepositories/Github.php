<?php

namespace Drupal\drupaleasy_repositories\Plugin\DrupaleasyRepositories;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\drupaleasy_repositories\DrupaleasyRepositories\DrupaleasyRepositoriesPluginBase;
use Github\AuthMethod;
use Github\Client;
use Symfony\Component\HttpClient\HttplugClient;


/**
 * Plugin implementation of the drupaleasy_repositories.
 *
 * @DrupaleasyRepositories(
 *   id = "github",
 *   label = @Translation("Github"),
 *   description = @Translation("Github.com.")
 * )
 */
class Github extends DrupaleasyRepositoriesPluginBase {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function validate(string $uri): bool {
    $pattern = '|^https://github.com/[a-zA-Z0-9_-]+/[a-zA-Z0-9_-]+|';

    if (preg_match($pattern, $uri) === 1) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function validateHelpText(): string {
    return 'https://github.com/vendor/name';
  }

  /**
   * Gets a single repository from Github.
   *
   * @param string $uri
   *   The URI of the repository to get.
   *
   * @return array
   *   The repositories.
   */
  public function getRepo(string $uri): array {
    // Parse the URI.
    $all_parts = parse_url($uri);
    $parts = explode('/', $all_parts['path']);

    // // Set up authentication with the Github API.
    // $this->setAuthentication();

    // try {
    //   $repo = $this->client->api('repo')->show($parts[1], $parts[2]);
    // }
    // catch (\Throwable $th) {
    //   //$this->messenger->addMessage($this->t('GitHub error: @error', [
    //   //  '@error' => $th->getMessage(),
    //   //]));
    //   return [];
    // }


    if ($this->authenticate()) {
      try {
        $repo = $this->client->api('repo')->show($parts[1], $parts[2]);
      }
      // Throwable is broader and includes Exception.
      catch (\Throwable $th) {
        //$this->messenger->addMessage($this->t('GitHub error: @error', [
        //   '@error' => $th->getMessage(),
        // ]));
        return [];
      }

      return $this->mapToCommonFormat($repo['full_name'], $repo['name'], $repo['description'], $repo['open_issues_count'], $repo['html_url']);
    }
    else {
      return [];
    }

  }

  /**
   * Authenticate with Github.
   */
  protected function authenticate(): bool {
    $this->client = Client::createWithHttpClient(new HttplugClient());
    // The authenticate() method does not actually call the Github API,
    // rather it only stores the authentication info in $client for use when
    // $client makes an API call that requires authentication.
    // $github_key = $this->keyRepository->getKey('github')->getKeyValues();
    try {
      // The authenticate() method does not return TRUE/FALSE, only an error if
      // unsuccessful. (Except that we added TRUE/FALSE stuff.)
      $this->client->authenticate('sara-ck',
      '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', AuthMethod::CLIENT_ID);
      // $this->client->authenticate($github_key['username'], $github_key['personal_access_token'], AuthMethod::CLIENT_ID);
      // do i need this? Not in repo. This is just to test the credentials.
      $this->client->currentUser()->emails()->allPublic();
    }
    catch (\Throwable $th) {
      $this->messenger->addMessage($this->t('GitHub error: @error', [
        '@error' => $th->getMessage(),
      ]));
      return FALSE;
    }

    return TRUE;

  }

}
