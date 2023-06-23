<?php
/**
 * @file
 * Contains \Drupal\greet\Controller\GreetController.
 */
namespace Drupal\greet\Controller;

use Drupal\Core\Controller\ControllerBase;

class GreetController extends ControllerBase {
  public function overview() {
    return array(
      '#type' => 'markup',
      '#markup' => 'Hello '. \Drupal::currentUser()->getDisplayName(),
    );
  }

  public function add() {
    if (\Drupal::currentUser()->hasPermission('greet permission 0')) {
      return array(
        '#type' => 'markup',
        '#markup' => 'Welcome ' . \Drupal::currentUser()->getEmail(),
      );
    }
  }
}
