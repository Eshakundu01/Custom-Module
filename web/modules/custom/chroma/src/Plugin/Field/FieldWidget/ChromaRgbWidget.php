<?php

namespace Drupal\chroma\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This widget helps in obtaining values of colour in integer format.
 *
 * @FieldWidget(
 *   id = "chroma_rgb",
 *   label = @Translation("RGB value"),
 *   description = @Translation("Provides three input field for values."),
 *   field_types = {
 *     "colour"
 *   },
 * )
 */
class ChromaRgbWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $hex_value = isset($items[$delta]->value) ? $items[$delta]->value : NULL;

    if (isset($hex_value)) {
      $default_colour = $this->getDefaultValue($hex_value);
    }
    else {
      $default_colour['red'] = NULL;
      $default_colour['green'] = NULL;
      $default_colour['blue'] = NULL;
    }

    $element += [
      '#type' => 'fieldset',
      '#title' => $this->t('RGB value collector'),
    ];

    $element['red'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#default_value' => $default_colour['red'],
      '#min' => 0,
      '#max' => 255,
    ];

    $element['green'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#default_value' => $default_colour['green'],
      '#min' => 0,
      '#max' => 255,
    ];

    $element['blue'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#default_value' => $default_colour['blue'],
      '#min' => 0,
      '#max' => 255,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$colour) {
      // Incase input provide the value is converted into hexvalue.
      if ($colour['red'] != '' && $colour['green'] != '' && $colour['blue'] != '') {
        $colour['value'] = sprintf('#%02x%02x%02x', $colour['red'], $colour['green'], $colour['blue']);
      }
    }

    return $values;
  }

  /**
   * Converts hex value of colour to provide rgb value.
   *
   * @param string $code
   *   The color value which is stored in hex value.
   *
   * @return array
   *   The converted integer value of colour.
   */
  public function getDefaultValue($code) {
    $hex = ltrim($code, '#');
    return [
      'red' => hexdec(substr($hex, 0, 2)),
      'green' => hexdec(substr($hex, 2, 2)),
      'blue' => hexdec(substr($hex, 4, 2)),
    ];
  }

}
