<?php
/**
* @file
* Contains Drupal\example_module\Form\TermForm.
*/

namespace Drupal\example_module\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
* Form controller for the content_entity_example entity edit forms.
*
* @ingroup content_entity_example
*/
class TermForm extends ContentEntityForm {

    /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        /* @var $entity \Drupal\example_module\Entity\Term */
        $form = parent::buildForm($form, $form_state);
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function save(array $form, FormStateInterface $form_state) {
        // Redirect to term list after save.
        $form_state->setRedirect('entity.dictionary_term.collection');
        $entity = $this->getEntity();
        $entity->save();
    }

}