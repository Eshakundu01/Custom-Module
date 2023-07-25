<?php

namespace Drupal\chroma\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Displays the code along with the colour in the background.
 *
 * @FieldFormatter(
 *   id = "chroma_background",
 *   label = @Translation("View Colour"),
 *   field_types = {
 *     "colour"
 *   },
 * )
 */
class ChromaBackgroundFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'rgb_value' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['rgb_value'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show RGB value of colour'),
      '#default_value' => $this->getSetting('rgb_value'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $settings = $this->getSettings();

    if ($settings['rgb_value']) {
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
      if ($settings['rgb_value']) {
        $element[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#value' => $this->colourFormat($item->value),
          '#attributes' => [
            'style' => 'background-color: ' . $item->value . ';',
          ],
        ];
      }
      else {
        $element[$delta] = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#value' => $item->value,
          '#attributes' => [
            'style' => 'background-color: ' . $item->value . ';',
          ],
        ];
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

    $result = 'rgb(' . $red . ', ' . $green . ', ' . $blue . ')';

    return $result;
  }

}
