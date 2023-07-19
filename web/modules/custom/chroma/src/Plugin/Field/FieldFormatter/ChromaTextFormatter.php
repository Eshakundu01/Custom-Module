<?php

namespace Drupal\chroma\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Displays the colour code as a text.
 *
 * @FieldFormatter(
 *   id = "chroma_text",
 *   label = @Translation("Colour value"),
 *   field_types = {
 *     "colour"
 *   },
 * )
 */
class ChromaTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'colour_value' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['colour_value'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display RGB value of colour'),
      '#default_value' => $this->getSetting('colour_value'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $settings = $this->getSettings();

    if ($settings['colour_value']) {
      $summary[] = $this->t('Displays the RGB value of colour.');
    }
    else {
      $summary[] = $this->t('Displays the hexcode of colour.');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $settings = $this->getSettings();

    foreach ($items as $delta => $item) {
      if ($settings['colour_value']) {
        $element[$delta] = ['#markup' => $this->colourFormat($item->value)];
      }
      else {
        $element[$delta] = ['#markup' => $item->value];
      }
    }

    return $element;
  }

  /**
   * The colour format is converted to rgb value.
   *
   * @param string $colours
   *   The actual stored value is fetched.
   *
   * @return string
   *   The converted value is represented in its format.
   */
  public function colourFormat($colours) {
    $hex = ltrim($colours, '#');
    $red = hexdec(substr($hex, 0, 2));
    $green = hexdec(substr($hex, 2, 2));
    $blue = hexdec(substr($hex, 4, 2));

    $result = "rgb(" . $red . ", " . $green . ", " . $blue . ")";

    return $result;
  }

}
