<?php

namespace Drupal\Tests\drupaleasy_repositories\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\drupaleasy_repositories\Plugin\DrupaleasyRepositories\YmlRemote;

/**
 * Test description.
 *
 * @group drupaleasy_repositories
 */
class YmlRemoteTest extends UnitTestCase {

  /**
   * The .yml remote plugin.
   *
   * @var \Drupal\drupaleasy_repositories\Plugin\DrupaleasyRepositories\YmlRemote
   */
  protected YmlRemote $ymlRemote;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->ymlRemote = new YmlRemote([], '', []);
  }

  /**
   * Test that the help text returns as expected.
   *
   * @covers ::validateHelpText
   * @test
   */
  public function testValidateHelpText(): void {
    self::assertEquals('https://anything.anything/anything/anything.yml (or "http")', $this->ymlRemote->validateHelpText(), 'Help text does not match.');
  }

  /**
   * Data provider for testValidate().
   */
  public function validateProvider(): array {
    return [
      [
        'A test string',
        FALSE,
      ],
      [
        'http://www.mysite.com/anything.yml',
        TRUE,
      ],
      [
        'https://www.mysite.com/anything.yml',
        TRUE,
      ],
      [
        'https://www.mysite.com/anything.yaml',
        FALSE,
      ],
      [
        '/var/www/html/anything.yaml',
        FALSE,
      ],
      [
        'https://www.mysite.com/some%20anything.yml',
        TRUE,
      ],
    ];
  }

  /**
   * Test that the URL validator works.
   *
   * @dataProvider validateProvider
   *
   * @covers ::validate
   * @test
   */
  public function testValidate($testString, $expected): void {
    self::assertEquals($expected, $this->ymlRemote->validate($testString));
  }

  /**
   * Test that a repo can be read properly.
   *
   * @covers ::getRepo
   * @test
   */
  public function testGetRepo(): void {
    $repo = $this->ymlRemote->getRepo(__DIR__ . '/../../assets/batman-repo.yml');
    $repo = reset($repo);
    self::assertEquals('The Batman repository', $repo['label'], 'Label does not match.');
    self::assertEquals('This is where Batman keeps all his crime-fighting code.', $repo['description'], 'Description does not match.');
  }

}
