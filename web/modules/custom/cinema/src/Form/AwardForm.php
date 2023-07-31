<?php

namespace Drupal\cinema\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Award Winners form.
 */
class AwardForm extends EntityForm {

  /**
   * The entity being used by this form.
   *
   * @var \Drupal\cinema\AwardInterface
   */
  protected $entity;

  /**
   * The awards entity storage.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $awardStorage;

  /**
   * Constructs a base class for cinema add and edit forms.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $awards
   *   The awards entity storage.
   */
  public function __construct(EntityTypeManagerInterface $awards) {
    $this->awardStorage = $awards;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $node = $this->awardStorage->getStorage('node');
    $movie_name = $this->entity->get('name');

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [$this, 'exist'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['name'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Movie Name'),
      '#target_type' => 'node',
      '#default_value' => isset($movie_name) ? $node->load($movie_name) : NULL,
      '#selection_settings' => [
        'target_bundles' => ['movie'],
      ],
      '#description' => $this->t('Only one value can be inputted.'),
    ];

    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new example %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated example %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

  /**
   * Helper function to check whether an Cinema configuration entity exists.
   */
  public function exist($id) {
    $entity = $this->awardStorage->getStorage('awards')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
