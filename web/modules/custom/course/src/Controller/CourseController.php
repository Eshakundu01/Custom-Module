<?php

/**
 * @file
 * Contains \Drupal\course\Controller\CourseController.
 */

namespace Drupal\course\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Returns the route for the course module.
 */
class CourseController extends ControllerBase {

  /**
   * Displays a page according to the render array.
   *
   * @return array
   */
  public function preview() {
    return [
      '#title' => $this->t('Routing System'),
      '#markup' => $this->t('Learning the basic of routing system in drupal.'),
    ];
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account) {
    // Checks permissions.
    return AccessResult::allowedIf($account->hasPermission('access the custom page'));
  }

  /**
   * Displays the argument in a page.
   *
   * @param int $number
   *   The value provided as parameter in the URI.
   * @return array
   *   Render-able array.
   */
  public function content($number) {

    return [
      '#theme' => 'course_parameter',
      '#points' => $number
    ];
    
  }
}
