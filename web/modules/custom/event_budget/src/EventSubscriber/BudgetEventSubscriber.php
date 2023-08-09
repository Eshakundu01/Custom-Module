<?php

namespace Drupal\event_budget\EventSubscriber;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Event subscriber to display budget comparison.
 */
class BudgetEventSubscriber implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * The event_budget.settings configurations.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * The messenger to display messages.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The route match service.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $route;

  /**
   * Constructs a BudgetEventSubscriber object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route
   *   The current route match.
   */
  public function __construct(ConfigFactoryInterface $configFactory, MessengerInterface $messenger, RouteMatchInterface $route) {
    $this->config = $configFactory;
    $this->messenger = $messenger;
    $this->route = $route;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::VIEW][] = ['onResponse', 5];
    return $events;
  }

  /**
   * React to the node view depending on the configurations.
   *
   * @param \Symfony\Component\HttpKernel\Event\ViewEvent $event
   *   The view event.
   */
  public function onResponse(ViewEvent $event) {
    $route_name = $this->route->getRouteName();

    if ($route_name === 'entity.node.canonical') {
      $node = $this->route->getParameter('node');
      if ($node->getType() == 'movie') {
        $config = $this->config->get('event_budget.settings');
        $cost = $config->get('movie_budget');
        $movie_price = $node->get('field_movie_price')->value;

        if ($cost > $movie_price) {
          $message = $this->t('The movie is under budget.');
        }
        elseif ($cost < $movie_price) {
          $message = $this->t('The movie is over budget.');
        }
        else {
          $message = $this->t('The movie is within budget.');
        }
        $this->messenger->addMessage($message);
      }
    }
  }

}
