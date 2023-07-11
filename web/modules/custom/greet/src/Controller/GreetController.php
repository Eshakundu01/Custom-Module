<?php

namespace Drupal\greet\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Greet routes.
 */
class GreetController extends ControllerBase {

  /**
   * The account details related to a user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
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
   * Displays the markup.
   *
   * @return array
   *   The markup content is returned.
   */
  public function view() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello World'),
    ];
  }

  /**
   * Displays the markup with the current users name.
   *
   * @return array
   *   The markup content is returned.
   */
  public function overview() {
    $user_name = $this->user->getDisplayName();
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello @name', ['@name' => $user_name]),
    ];
  }

  /**
   * Displays user's email address as markup.
   *
   * @return array
   *   The markup is returned.
   */
  public function add() {
    if ($this->user->hasPermission('add greet permission')) {
      return [
        '#type' => 'markup',
        '#markup' => 'Welcome ' . $this->user->getEmail(),
      ];
    }
  }

}
