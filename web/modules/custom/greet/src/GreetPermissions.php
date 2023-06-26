<?php

namespace Drupal\greet;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides dynamic permissions for greet module.
 */
class GreetPermissions {

  use StringTranslationTrait;
  
  /**
   * In this function an array is taken which is then looped through to add
   * permissions dynamically and in case the array index value is 1 restrict
   * access becomes true.
   * 
   * @return array
   *   The greet permissions.
   */
  public function permissions() {
    $permissions = [];

    $value = ['Add', 'Edit'];
    foreach ($value as $key => $words) {
      $permissions += [
        strtolower($words) . " greet permission" => [
          'title' => $this->t('@name permission', ['@name' => $words]),
          'description' => $this->t('This is a sample permission generated dynamically.'),
          'restrict access' => $key == 1 ? true : false,
        ],
      ];
    }
    return $permissions;
  }
}
