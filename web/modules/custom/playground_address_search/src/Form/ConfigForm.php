<?php

namespace Drupal\playground_address_search\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\TypedConfigManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['playground_address_search.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'playground_address_search_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('playground_address_search.settings');
    $form['rapid_api_key'] = [
      '#title' => $this->t('RapidAPI Key'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#description' => $this->t('This is used for the request X-RapidAPI-Key header.'),
      '#default_value' => $config->get('rapid_api_key'),
    ];

    $form['rapid_api_host'] = [
      '#title' => $this->t('RapidAPI Host'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#description' => $this->t('This is used for the request X-RapidAPI-Host header.'),
      '#default_value' => $config->get('rapid_api_host'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('playground_address_search.settings')
      ->set('rapid_api_key', $form_state->getValue('rapid_api_key'))
      ->set('rapid_api_host', $form_state->getValue('rapid_api_host'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
