<?php

namespace Drupal\playground_address_search\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'address_autocomplete' widget.
 */
#[FieldWidget(
  id: 'address_autocomplete_widget',
  label: new TranslatableMarkup('Address field widget'),
  field_types: ['address_autocomplete'],
)]
class  AddressAutocompleteWidget extends WidgetBase {

  /**
   * @inheritDoc
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
      '#default_value' => $items[$delta]->value ?? '',
      '#autocomplete_route_name' => 'playground_address_search.autocomplete'
    ];
    return $element;
  }
}
