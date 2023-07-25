<?php

namespace Drupal\user_role\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns the route for the user_role module.
 */
class UserRoleController extends ControllerBase {

  /**
   * Displays a page according to the render array.
   *
   * @return array
   *   The markup content is returned.
   */
  public function content() {
    return [
      '#title' => $this->t('Welcome Page'),
      '#markup' => $this->t('Lorem, ipsum dolor sit amet consectetur adipisicing
      elit. Sequi eligendi ab ipsam et iusto deleniti aut eius, minima nulla
      voluptatibus perferendis earum quas soluta libero, sit quasi. Quo
      explicabo vitae cupiditate, necessitatibus assumenda mollitia incidunt
      dignissimos sit rem ea quae, officia eius perferendis voluptatem. Natus
      assumenda odit, optio voluptatum omnis sed, possimus a deleniti totam nam
      tempore neque distinctio numquam quidem officiis quos excepturi velit
      molestias repellendus sequi pariatur perspiciatis sit ea quibusdam?
      Officiis aliquid maiores voluptatibus libero voluptas.'),
    ];
  }
}
