<?php
/**
 * @file
 * Contains \Drupal\example_module\Form\TermSettingsForm.
 */

namespace Drupal\example_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ContentEntityExampleSettingsForm.
 *
 * @package Drupal\example_module\Form
 *
 * @ingroup dictionary
 */
class TermSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'dictionary_term_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['dictionary_term_settings']['#markup'] = 'Settings form for Dictionary Term. Manage field settings here.';
    return $form;
  }

}