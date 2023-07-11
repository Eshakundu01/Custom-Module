<?php

namespace Drupal\greet;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides dynamic permissions for greet module.
 */
class GreetPermissions {
  use StringTranslationTrait;

  /**
   * Dynamically permissions are added, restricting the permission with index 1.
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
          'restrict access' => $key == 1 ? TRUE : FALSE,
        ],
      ];
    }
    return $permissions;
  }

}
