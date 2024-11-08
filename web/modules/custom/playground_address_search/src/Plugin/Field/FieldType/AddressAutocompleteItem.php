<?php

namespace Drupal\playground_address_search\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'address_autocomplete' field type.
 */
#[FieldType(
  id: "address_autocomplete",
  label: new TranslatableMarkup("Address search"),
  description: new TranslatableMarkup("Auto complete address string using rapidapi API."),
  default_widget: "address_autocomplete_widget",
  default_formatter: "address_autocomplete_formatter",

)]
class AddressAutocompleteItem extends FieldItemBase {

  /**
   * @inheritDoc
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Address'));
    return $properties;
  }

  /**
   * @inheritDoc
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 255,
        ],
      ],
    ];
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }


}
