<?php

namespace Drupal\playground_address_search\Unit;

use Drupal\Core\Config\Config;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\playground_address_search\Services\AddressSearchApiConnection;
use Drupal\Tests\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Tests the Playground Address Search API.
 *
 * @coversDefaultClass \Drupal\playground_address_search\Services\AddressSearchApiConnection
 * @group playground_address_search
 */
class PlaygroundAddressSearchTest extends UnitTestCase {

  /**
   * @var MockObject|\Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactoryMock;

  /**
   * @var MockObject|\Drupal\Core\Config\Config
   */
  private $configMock;

  /**
   * @var AddressSearchApiConnection
   */
  protected $addressSearchServiceMock;

  protected function setUp(): void {
    parent::setUp();

    // Create a mock for the Config object.
    $this->configMock = $this->createMock(Config::class);
    // willReturnMap() is used to specify multiple return values based on the argument passed to get()
    $this->configMock->method('get')
      ->willReturnMap([
        ['rapid_api_host', 'example_host_value'],
        ['rapid_api_key', 'example_key_value'],
      ]);

    // Create a mock for the ConfigFactoryInterface.
    $this->configFactoryMock = $this->createMock(ConfigFactoryInterface::class);

    // Method Stubbing: The getEditable() method of the ConfigFactoryInterface mock is stubbed to
    // return the mocked Config object when called with 'playground_address_search.settings'.
    $this->configFactoryMock->method('getEditable')
      ->with('playground_address_search.settings')
      ->willReturn($this->configMock);

    // Instantiate the service with the mocked ConfigFactoryInterface.
    $this->addressSearchServiceMock = new AddressSearchApiConnection($this->configFactoryMock);
  }

  /**
   * Tests the constructor and configuration values.
   */
  public function testConstructor() {
    // Use Reflection to access private or protected properties.
    $reflectionHost = new \ReflectionProperty($this->addressSearchServiceMock, 'rapid_api_host');
    // Make the private or protected property accessible to read.
    $reflectionHost->setAccessible(true);
    $this->assertEquals('example_host_value', $reflectionHost->getValue($this->addressSearchServiceMock));

    $reflectionKey = new \ReflectionProperty($this->addressSearchServiceMock, 'rapid_api_key');
    $reflectionKey->setAccessible(true);
    $this->assertEquals('example_key_value', $reflectionKey->getValue($this->addressSearchServiceMock));
  }

  public function testCheckSettings() {
    $this->assertTrue($this->configFactoryMock instanceof ConfigFactoryInterface);

    // Assert that checkSettings returns true with valid settings.
    $this->assertTrue($this->addressSearchServiceMock->checkSettings());
  }
}
