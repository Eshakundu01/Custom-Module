<?php

namespace Drupal\chroma\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Colour for colour field can be selected using colour picker.
 *
 * @FieldWidget(
 *   id = "chroma_colour_picker",
 *   label = @Translation("Colour Pick"),
 *   description = @Translation("Select the colour present in the picker."),
 *   field_types = {
 *     "colour"
 *   },
 * )
 */
class ChromaColourPick extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $colour_value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $element += [
      '#type' => 'color',
      '#title' => $this->t('Colour Picker'),
      '#default_value' => $colour_value,
    ];
    return ['value' => $element];
  }

}
