<?php

namespace Drupal\greet;

use Drupal\Core\StringTranslation\StringTranslationTrait;

class GreetPermissions {

  use StringTranslationTrait;
  
  /**
   * @return array
   */
  public function permissions()
  {
    $permissions = [];

    $value = ['Add', 'Edit'];
    foreach ($value as $key => $words) {
      $permissions += [
        "greet permission $key" => [
          'title' => $this->t('@name permission', ['@name' => $words]),
          'description' => $this->t('This is a sample permission generated dynamically.'),
          'restrict access' => $key == 1 ? true : false,
        ],
      ];
    }
    return $permissions;
  }
}
