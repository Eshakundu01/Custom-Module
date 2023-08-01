<?php

namespace Drupal\cinema\Entity;

use Drupal\cinema\AwardInterface;
use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the award won by entity type.
 *
 * @ConfigEntityType(
 *   id = "awards",
 *   label = @Translation("Award Winner"),
 *   label_collection = @Translation("Cinema"),
 *   label_singular = @Translation("award"),
 *   label_plural = @Translation("awards"),
 *   label_count = @PluralTranslation(
 *     singular = "@count award",
 *     plural = "@count awards",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\cinema\AwardListBuilder",
 *     "form" = {
 *       "add" = "Drupal\cinema\Form\AwardForm",
 *       "edit" = "Drupal\cinema\Form\AwardForm",
 *       "delete" = "Drupal\cinema\Form\AwardDeleteForm",
 *     },
 *   },
 *   config_prefix = "awards",
 *   admin_permission = "administer awards",
 *   links = {
 *     "collection" = "/admin/config/media/awards",
 *     "add-form" = "/admin/config/media/add",
 *     "edit-form" = "/admin/config/media/{awards}",
 *     "delete-form" = "/admin/config/media/awards/{awards}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "name",
 *   },
 * )
 */
class Award extends ConfigEntityBase implements AwardInterface {

  /**
   * The award ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The award name.
   *
   * @var string
   */
  protected $label;

  /**
   * The movie name id that won the award.
   *
   * @var int
   */
  protected $name;

}
