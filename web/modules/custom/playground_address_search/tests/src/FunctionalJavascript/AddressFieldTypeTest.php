<?php

declare(strict_types=1);

namespace Drupal\Tests\playground_address_search\FunctionalJavascript;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ResponseTextException;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\FunctionalJavascriptTests\JSWebAssert;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Tests\field_ui\Traits\FieldUiJSTestTrait;

class AddressFieldTypeTest extends WebDriverTestBase {

  use FieldUiJSTestTrait;

  /**
   * The content type id.
   *
   * @var string
   */
  protected string $type;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'claro';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'system',
    'field_ui',
    'playground_address_search'
  ];

  /**
   * {@inheritdoc}
   * @throws EntityStorageException
   */
  protected function setUp(): void {
    parent::setUp();
    $content_editor = $this->drupalCreateUser([
      'access content',
      'administer node fields',
      'administer node form display',
      'administer node display',
      'administer playground address search settings'
    ]);

    // Create content type, with underscores.
    $type_name = $this->randomMachineName(8) . '_test';
    $type = $this->drupalCreateContentType([
      'name' => $type_name,
      'type' => $type_name,
    ]);
    $this->type = $type->id();

    $this->drupalLogin($content_editor);

  }

  /**
   * Ensure address autocomplete field type is visible and functional to the user.
   * @return void
   * @throws ElementNotFoundException
   * @throws ResponseTextException
   */
  public function testAddressAutocompleteFieldType(): void {
    $manage = 'admin/structure/types/manage/';
    $path = $manage . $this->type . '/';
    /** @var JSWebAssert $assert_session */
    $assert_session = $this->assertSession();

    $this->fieldUIAddNewFieldJS($path, 'address_search_demo', 'Address Search', 'address_autocomplete', false);
    $page = $this->getSession()->getPage();
    $page->pressButton('Save settings');

    // Display the "Manage display" page.
    $this->drupalGet($path . 'form-display');
    $assert_session->fieldExists('Address Search');

    $this->drupalGet($path . 'fields');
    $assert_session->pageTextContains('address_search_demo');
  }


  function tearDown(): void {
    parent::tearDown();
  }

}
