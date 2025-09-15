<?php

namespace Drupal\digitalia_muni_field_widgets\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\controlled_access_terms\Plugin\Field\FieldWidget\TypedRelationWidget;

/**
 * Plugin implementation of the 'typed_relation_autocomplete' widget.
 *
 * @FieldWidget(
 *   id = "typed_relation_autocomplete",
 *   label = @Translation("Typed Relation Autocomplete"),
 *   field_types = {
 *     "typed_relation"
 *   }
 * )
 */

class TypedRelationAutocompleteWidget extends TypedRelationWidget {

    /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'target_id_label' => t('Target'),
      'rel_type_label' => t('Relationship type'),
    ] + parent::defaultSettings();
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
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['target_id']['#title'] = $this->getSetting('target_id_label');
    $element['target_id']['#title_display'] = 'before';
    $element['rel_type']['#title'] = $this->getSetting('rel_type_label');

    return $element;
  }

}