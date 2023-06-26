<?php
/**
 * @file
 * Contains \Drupal\greet\Controller\GreetController.
 */
namespace Drupal\greet\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Greet routes.
 */
class GreetController extends ControllerBase {

  /**
   * Displays the markup.
   *
   * @return array
   *   The markup content is returned.
   */
  public function view() {
    return [
      '#type' => 'markup',
      '#markup' => 'Hello World',
    ];
  }

  /**
   * Displays the markup with the current users name.
   *
   * @return array
   *   The markup content is returned.
   */
  public function overview() {
    return [
      '#type' => 'markup',
      '#markup' => 'Hello '. \Drupal::currentUser()->getDisplayName(),
    ];
  }

  /**
   * Adds new markup content that is going to be displayed with the current
   * users email address.
   * 
   * @return mixed
   *   The result as per the access is returned.
   */
  public function add() {
    if (\Drupal::currentUser()->hasPermission('add greet permission')) {
      return [
        '#type' => 'markup',
        '#markup' => 'Welcome ' . \Drupal::currentUser()->getEmail(),
      ];
    }
  }
}
