<?php

namespace Drupal\starrating\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'addtocart' widget.
 *
 * @FieldWidget(
 *   id = "starrating",
 *   module = "starrating",
 *   label = @Translation("Star Rating"),
 *   field_types = {
 *     "starrating"
 *   }
 * )
 */
class StarRatingWidget extends WidgetBase {
 
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = isset($items[$delta]->value) ? $items[$delta]->value : '';
    $field_settings = $this->getFieldSettings();
    $max_value = $field_settings['max_value'];
      $options = array();
    //handle "null" as a string so the form will validate
    $options['null'] = t('Not selected');
    for ($i = 0; $i <= $max_value; $i++) {
      $options[$i] = $i;
    }

 
    $element += array(
      '#type' => 'select',
      '#default_value' => null,
      '#options' => $options,
    );
    return array('value' => $element);
  }
}
