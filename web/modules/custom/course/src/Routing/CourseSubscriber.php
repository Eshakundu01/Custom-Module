<?php

/**
 * @file
 * This file alters the existing route.
 */
namespace Drupal\course\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the route events.
 */
class CourseSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Only administrator role can access the page.
    if ($route = $collection->get('course.access')) {
      $route->setRequirement('_role', 'administrator');
    }
    
  }

}
