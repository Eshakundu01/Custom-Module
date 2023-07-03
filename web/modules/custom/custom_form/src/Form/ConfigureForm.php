<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures custom_form’s settings.
 */
class ConfigureForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_form.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_form.settings');

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      '#placeholder' => 'Enter your full name',
      '#default_value' => $config->get('full_name'),
    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      '#placeholder' => 'Enter your phone number',
      '#default_value' => $config->get('phone_number'),
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => TRUE,
      '#placeholder' => 'Enter your email e.g. example@email.com',
      '#default_value' => $config->get('email'),
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => 'Select your Gender',
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'others' => $this->t('Others'),
      ],
      '#default_value' => $config->get('gender'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // The array consists of public domain that are allowed.
    $domain = ['gmail','yahoo','outlook'];

    // The value received from the email input field.
    $mail = $form_state->getValue('email');

    // Split the email to obtain the domain part.
    $domain_part = explode('.', array_pop(explode('@', $mail)));

    // Checks if the phone number starts with +91 followed by 10 digit number.
    if (!preg_match('/^\+91\d{10}$/', $form_state->getValue('phone_number'))) {
      $form_state->setErrorByName('phone_number', $this->t('Only Indian phone number is accepted, starting with +91 followed by 10 digits'));
    }

    // Validates the email format, the domain and ends with '.com'.
    if (!(filter_var($mail, FILTER_VALIDATE_EMAIL))) {
      $form_state->setErrorByName('email', $this->t('Invalid email address.'));
    } elseif (!(in_array($domain_part[0], $domain) && str_ends_with($mail, '.com'))) {
      $form_state->setErrorByName('email', $this->t('Only yahoo, gmail, outlook must be used ending with .com'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_form.settings')
      ->set('full_name', $form_state->getValue('full_name'))
      ->set('phone_number', $form_state->getValue('phone_number'))
      ->set('email', $form_state->getValue('email'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();
  }
}
