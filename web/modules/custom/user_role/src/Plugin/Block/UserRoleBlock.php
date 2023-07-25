<?php

namespace Drupal\user_role\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'User Role' block.
 *
 * @Block(
 *   id = "user_role_block",
 *   admin_label = @Translation("User Role Block"),
 * )
 */
class UserRoleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->user = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $role = join(',', $this->user->getRoles(TRUE));
    return [
      '#markup' => $this->t('Welcome @roles', ['@roles' => $role]),
    ];
  }
}
