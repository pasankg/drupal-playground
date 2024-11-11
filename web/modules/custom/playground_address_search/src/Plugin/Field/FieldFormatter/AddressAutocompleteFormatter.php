<?php

namespace Drupal\playground_address_search\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'address_autocomplete' formatter.
 */
#[FieldFormatter(
  id: 'address_autocomplete_formatter',
  label: new TranslatableMarkup('Address search'),
  field_types: [
    'address_autocomplete',
  ],
)]
class AddressAutocompleteFormatter extends FormatterBase {

  /**
   * @inheritDoc
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $item->value];
    }
    return $elements;
  }
}
