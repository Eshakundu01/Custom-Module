<?php

namespace Drupal\course\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns the route for the course module.
 */
class CourseController extends ControllerBase {

  /**
   * The current user is accessed.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $user;

  /**
   * Constructs a new CourseController object.
   *
   * @param AccountInterface $account
   *   The account service is used.
   */
  public function __construct(AccountInterface $account) {
    $this->user = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('current_user'));
  }

  /**
   * Displays a page according to the render array.
   *
   * @return array
   *   The markup is returned.
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
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access() {
    // Checks permissions.
    return AccessResult::allowedIf($this->user->hasPermission('access the custom page'));
  }

  /**
   * Displays the argument in a page.
   *
   * @param int $number
   *   The value provided as parameter in the URI.
   *
   * @return array
   *   Render-able array.
   */
  public function content($number) {
    return [
      '#theme' => 'course_parameter',
      '#points' => $number,
    ];
  }

}
