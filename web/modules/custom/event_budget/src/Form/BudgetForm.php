<?php

namespace Drupal\event_budget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures budget settings.
 */
class BudgetForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_budget_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'event_budget.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('event_budget.settings');

    $form['movie_budget'] = [
      '#type' => 'number',
      '#title' => $this->t('Movie Budget'),
      '#required' => TRUE,
      '#default_value' => $config->get('movie_budget'),
      '#description' => $this->t('The estimated budget for a movie.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('event_budget.settings')
      ->set('movie_budget', $form_state->getValue('movie_budget'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
