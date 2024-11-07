<?php

namespace Drupal\Tests\playground_form\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

class UserRegisterFormTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    // Core system and user modules that are fundamental.
    'system',
    'user',

    // Core field modules, required before custom field types and field groups.
    'field',
    'path',
    'text',
    'filter',
    'options',
    'datetime',
    'telephone',
    'file',
    'image',

    // Modules for layout and field grouping.
    'field_group',
    'field_layout',
    'layout_builder',
    'layout_discovery',

    // Custom modules that depend on the above core and contributed modules.
    'playground_address_search',
    'playground_form',
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'playground';

  protected function setUp(): void {
    parent::setUp();
    $adminUser = $this->drupalCreateUser();
    $adminRole = $this->drupalCreateRole([
      'administer site configuration',
      'administer permissions',
      'access administration pages',
      'access content',
      'administer users',
      'administer modules',
    ]);

    $adminUser->addRole($adminRole)->save();

    \Drupal::service('config.installer')->installDefaultConfig('module', 'playground_form');

    $this->drupalLogin($adminUser);
    $this->drupalGet('admin/modules');
  }

  /**
   * Verifies that new fields exists.
   */
  public function testNewFieldsOnUserRegistrationForm(): void {
    $this->drupalGet(Url::fromRoute('user.edit'));
    $this->assertSession()->pageTextMatchesCount(1, '/Please share a bit about you./');
    $this->assertSession()->pageTextMatchesCount(2, '/About me/');

    // @TODO This assert doesn't seem to work as the placeholder do not show up in the browser test.
    // $this->assertSession()->pageTextMatchesCount(1, '/Please enter your address./');

    $this->assertSession()->pageTextMatchesCount(1, '/Address/');
  }

  protected function tearDown(): void {
    parent::tearDown();
  }

}
