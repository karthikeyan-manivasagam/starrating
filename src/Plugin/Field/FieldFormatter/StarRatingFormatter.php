<?php

namespace Drupal\starrating\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Form\FormStateInterface;
/**
 * Plugin implementation of the 'addtocart' formatter.
 *
 * @FieldFormatter(
 *   id = "starrating",
 *   module = "starrating",
 *   label = @Translation("Star Rating"),
 *   field_types = {
 *     "starrating"
 *   }
 * )
 */
class StarRatingFormatter extends FormatterBase {

/**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'fill_blank' => 0,
      'icon_type' => 'star',
      'icon_color' => 1,
    ) + parent::defaultSettings();
  }
  
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    $field_settings = $this->getFieldSettings();
    $max = $field_settings['max_value'];
    $min = 0;
    $icon_type = $this->getSetting('icon_type');
    $icon_color = $this->getSetting('icon_color');
    $fill_blank = $this->getSetting('fill_blank');
      foreach ($items as $delta => $item) {
        $rate = $item->value;  
        $elements[$delta] = ['#markup' => $this->formatterExecute($rate, $min, $max, $icon_type, $icon_color, $fill_blank)];
        $elements['#attached']['library'][] = 'starrating/'.$icon_type;
      }
    return $elements;
  }

 /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

$element = array();
  $element['fill_blank'] = array(
    '#type' => 'checkbox',
    '#title' => t('Fill with blank icons'),
    '#default_value' => $this->getSetting('fill_blank'),
  );

  $element['icon_type'] = array(
    '#type' => 'select',
    '#title' => t('Icon type'),
    '#options' => array(
      'star' => t('Star'),
      'starline' => t('Star (outline)'),
      'check' => t('Check'),
      'heart' => t('Heart'),
      'dollar' => t('Dollar'),
      'smiley' => t('Smiley'),
      'food' => t('Food'),
      'coffee' => t('Coffee'),
      'movie' => t('Movie'),
      'music' => t('Music'),
      'human' => t('Human'),
      'thumbsup' => t('Thumbs Up'),
      'car' => t('Car'),
      'airplane' => t('Airplane'),
      'fire' => t('Fire'),
      'drupalicon' => t('Drupalicon'),
      'custom' => t('Custom'),
    ),
    '#default_value' => $this->getSetting('icon_type'),
    '#prefix' => '<img src="/' . drupal_get_path('module', 'starrating') . '/icons/sample.png" />',
  );
  $element['icon_color'] = array(
    '#type' => 'select',
    '#title' => t('Icon color'),
    '#options' => array(1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8'),
    '#default_value' => $this->getSetting('icon_color'),
  );

    return $element;
  }


  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $field_settings = $this->getFieldSettings();
    $max = $field_settings['max_value'];
    $min = 0;
    $rate = $max;
    $icon_type = $this->getSetting('icon_type');
    $icon_color = $this->getSetting('icon_color');
    $fill_blank = $this->getSetting('fill_blank');
    $elements = [];
    $elements['#markup'] = $this->formatterExecute($rate, $min, $max, $icon_type, $icon_color, $fill_blank);
    $elements['#attached']['library'][] = 'starrating/'.$icon_type;
    $summary[] = $elements;

    return $summary;
  }

  /**
   * {@inheritdoc}
   */

  public function formatterExecute($rate, $min, $max, $icon_type, $icon_color, $fill_blank) {
          // add hidden text to support copy/paste and voice reading
  //$out = '<span style="position:absolute;left:-9999px">' . $rate . '</span>';

    $out = "<div class='starrating'>";
     
    for ($i = $min; $i < $max; $i++) {
      if (($i == $rate) && (!$fill_blank)) {
        break;
      }
      if ($i >= $rate) {
        $class = $icon_type . '-off';
      }
      else {
        $class = $icon_type . $icon_color . '-on';
      }
      if ($i % 2) {
        $class .= ' odd';
      }
      else {
        $class .= ' even';
      }
      $class .= ' s' . ($i + 1);

      $out .= '<div class="rate-image ' . $class . '"></div>';
    }

    $out .= "</div>";
    return $out;
  }

}

