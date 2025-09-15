<?php

namespace Drupal\digitalia_muni_field_widgets\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\controlled_access_terms\Plugin\Field\FieldWidget\TypedRelationWidget;

/**
 * Plugin implementation of the 'typed_relation_select' widget.
 *
 * @FieldWidget(
 *   id = "typed_relation_select",
 *   label = @Translation("Typed Relation Select list"),
 *   field_types = {
 *     "typed_relation"
 *   }
 * )
 */

class TypedRelationSelectWidget extends WidgetBase {

    /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'target_id_label' => t('Target'),
      'rel_type_label' => t('Relationship type'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements['target_id_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Target ID field label'),
      '#default_value' => $this->getSetting('target_id_label'),
      '#description' => $this->t('Label shown above the target select dropdown.'),
    ];

    $elements['rel_type_label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Relationship type field label'),
      '#default_value' => $this->getSetting('rel_type_label'),
      '#description' => $this->t('Label shown above the relationship type select.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Target ID label: @label', ['@label' => $this->getSetting('target_id_label')]);
    $summary[] = $this->t('Relationship type label: @label', ['@label' => $this->getSetting('rel_type_label')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];

    $item =& $items[$delta];
    $settings = $item->getFieldDefinition()->getSettings();

    // Get the entity reference handler for the target_id subfield.
    $handler_settings = $this->getFieldSetting('handler_settings');
    
    // Get the target entity type for the reference field.
    $target_type = $this->getFieldSetting('target_type');
    $options = [];
    
    if ($target_type == 'taxonomy_term') {
      $vocabularies = $handler_settings['target_bundles'] ?? [];
      // Loop only allowed vocabs.
      foreach ($vocabularies as $vid) {
        $terms = \Drupal::entityTypeManager()
          ->getStorage('taxonomy_term')
          ->loadTree($vid, 0, NULL, TRUE);

        foreach ($terms as $term) {
          $options[$term->id()] = $term->label();
        }
      }
    }
    elseif ($target_type == 'node') {
      $bundles = $handler_settings['target_bundles'] ?? [];
      $query = \Drupal::entityQuery('node');
      if (!empty($bundles)) {
        $query->condition('type', $bundles, 'IN');
      }
      $nids = $query->accessCheck(FALSE)->execute();
      if (!empty($nids)) {
        $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
        foreach ($nodes as $node) {
          $options[$node->id()] = $node->label();
        }
      }
    }
    elseif ($target_type == 'user') {
      $uids = \Drupal::entityQuery('user')
        ->condition('status', 1)
        ->accessCheck(FALSE)
        ->execute();
      if (!empty($uids)) {
        $users = \Drupal::entityTypeManager()->getStorage('user')->loadMultiple($uids);
        foreach ($users as $user) {
          $options[$user->id()] = $user->getDisplayName();
        }
      }
    }
    
    $element['target_id'] = [
      '#type' => 'select',
      '#title' => $this->getSetting('target_id_label'),
      '#options' => $options,
      '#default_value' => $item->target_id ?: NULL,
      '#empty_value' => NULL,
      '#empty_option' => $this->t('- Select -'),
    ];

    $element['rel_type'] = [
      '#title' => $this->getSetting('rel_type_label'),
      '#type' => 'select',
      '#options' => $settings['rel_types'],
      '#default_value' => isset($item->rel_type) && $item->rel_type !== '' ? $item->rel_type : NULL,
      '#empty_option' => $this->t('- Select -'),
      '#weight' => -1,
    ];

    return $element;
  }
}