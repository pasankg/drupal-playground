<?php

declare(strict_types=1);

namespace Drupal\Tests\playground_address_search\FunctionalJavascript;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ResponseTextException;
use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

class AddressFieldUserCreateFormTest extends WebDriverTestBase {


  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'olivero';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
  }

  /**
   * Ensure address field is visible and functional for the user.
   * @return void
   * @throws ElementNotFoundException
   * @throws ResponseTextException
   */
  public function testCreateUserForm(): void {
    $this->assertSession()->waitForButton('Menu', 1000);
    $this->click("button.mobile-nav-button");
    $this->assertSession()->waitForButton('Sign in', 1000);
    $this->clickLink('Sign in');
    $this->assertSession()->pageTextContains('Create new account');
    $this->clickLink('Create new account');
    $this->assertSession()->waitForField('Address', 1000);
    $page = $this->getSession()->getPage();
    $page->fillField('field_address[0][value]', 'Unit 4 Jac');

    $this->assertSession()->waitForElementVisible(
      'css',
      '#ui-id-1 li',
      3000
    );

    $this->getSession()->getPage()->find('css', '#ui-id-1 li');

    $this->assertJsCondition("document.querySelector('#ui-id-1 li') !== null");

    // Assert that suggestions are present.
    $suggestions = $page->findAll('css', '#ui-id-1 li');
    $this->assertNotEmpty($suggestions, 'Autocomplete suggestions are loaded.');

    // Check for specific suggestion text.
    $suggestion_texts = array_map(fn($item) => $item->getText(), $suggestions);
    $this->assertContains('UNIT 4, JACANA, 1 URE CT, BUDERIM QLD 4556', $suggestion_texts, 'Expected suggestion is found.');
  }

  function tearDown(): void {
    parent::tearDown();
  }

}
