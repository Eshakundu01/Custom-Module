<?php

namespace Drupal\chroma\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This is the widget for obtaining hex value of colours.
 *
 * @FieldWidget(
 *   id = "chroma_hex_value",
 *   label = @Translation("Hex value of colour"),
 *   description = @Translation("Obatins the hexadecimal value of a colour."),
 *   field_types = {
 *     "colour"
 *   },
 * )
 */
class ChromaHexWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'textfield',
      '#title' => $this->t('Hex value of Colour'),
      '#default_value' => $value,
      '#maxlength' => 7,
      '#element_validate' => [
        [$this, 'validate'],
      ],
    ];
    return ['value' => $element];
  }

  /**
   * Validate the color text field.
   */
  public function validate($element, FormStateInterface $form_state) {
    $value = $element['#value'];
    if (!preg_match('/^#([a-f0-9]{6})$/', strtolower($value))) {
      $form_state->setError($element, $this->t("Color must be a 6-digit hexadecimal value, suitable for CSS."));
    }
  }

}
