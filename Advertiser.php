<?php
namespace Drupal\drupal10_custom_module\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\example_module\AdvertiserInterface;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\EntityChangedTrait;
/**
 * Defines the Advertiser entity.
 *
 * @ingroup advertiser
 *
 * @ContentEntityType(
 *   id = "advertiser",
 *   label = @Translation("Advertiser"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\example_module\Entity\Controller\AdvertiserListBuilder",
 *     "form" = {
 *       "default" = "Drupal\example_module\Form\AdvertiserForm",
 *       "delete" = "Drupal\example_module\Form\AdvertiserDeleteForm",
 *     },
 *     "access" = "Drupal\example_module\AdvertiserAccessControlHandler",
 *   },
 *   list_cache_contexts = { "user" },
 *   base_table = "advertiser",
 *   admin_permission = "administer advertiser entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "created" = "created",
 *     "changed" = "changed",
 *   },
 *   links = {
 *     "canonical" = "/advertiser/{advertiser}",
 *     "edit-form" = "/advertiser/{advertiser}/edit",
 *     "delete-form" = "/contact/{advertiser}/delete",
 *     "collection" = "/advertiser/list"
 *   },
 *   field_ui_base_route = "advertiser.advertiser_settings",
 * )
 */
class Advertiser extends ContentEntityBase implements AdvertiserInterface {
    
    use EntityChangedTrait;
     /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set the user_id entity reference to
   * the current user as the creator of the instance.
   */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
        parent::preCreate($storage_controller, $values);
        $values += [
        'user_id' => \Drupal::currentUser()->id(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner() {
        return $this->get('user_id')->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId() {
        return $this->get('user_id')->target_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwnerId($uid) {
        $this->set('user_id', $uid);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(UserInterface $account) {
        $this->set('user_id', $account->id());
        return $this;
    }
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
  
      // Standard field, used as unique if primary index.
        $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('The ID of the Advertiser entity.'))
            ->setReadOnly(TRUE);
  
      // Standard field, unique outside of the scope of the current project.
        $fields['uuid'] = BaseFieldDefinition::create('uuid')
            ->setLabel(t('UUID'))
            ->setDescription(t('The UUID of the Advertiser entity.'))
            ->setReadOnly(TRUE);
 
        $fields['langcode'] = BaseFieldDefinition::create('language')
            ->setLabel(t('Language code'))
            ->setDescription(t('The user language code.'))
            ->setDisplayOptions('form', ['region' => 'hidden']);
        // Name field for the contact.
        // We set display options for the view as well as the form.
        // Users with correct privileges can change the view and edit configuration.
        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Name'))
            ->setDescription(t('The name of the Advertiser entity.'))
            ->setSettings([
            'max_length' => 255,
            'text_processing' => 0,
            ])
            // Set no default value.
            ->setDefaultValue(NULL)
            ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'string',
            'weight' => -6,
            ])
            ->setDisplayOptions('form', [
            'type' => 'string_textfield',
            'weight' => -6,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
        $fields['first_name'] = BaseFieldDefinition::create('string')
            ->setLabel(t('First Name'))
            ->setDescription(t('The name of the Advertiser entity.'))
            ->setSettings([
            'max_length' => 255,
            'text_processing' => 0,
            ])
            // Set no default value.
            ->setDefaultValue(NULL)
            ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'string',
            'weight' => -6,
            ])
            ->setDisplayOptions('form', [
            'type' => 'string_textfield',
            'weight' => -6,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
        $fields['image'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Promotion image'))
            ->setDescription(t('Recommended image size is 1600x900 pixels.'))
            ->setRevisionable(TRUE)
            ->setTranslatable(TRUE)
            ->setRequired(FALSE)
            ->setSetting('target_type', 'media')
            ->setSetting('handler', 'default:media')
            ->setSettings([
              'handler_settings' => [
                'target_bundles' => [
                  'image' => 'image',
                ],
                'sort' => [
                  'field' => '_none',
                ],
                'auto_create' => FALSE,
                'auto_create_bundle' => '',
              ],
            ])
            ->setCardinality(10)
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE)
            ->setDisplayOptions('form', [
              'settings' => [
                'entity_browser' => 'image_browser',
                'field_widget_display' => 'rendered_entity',
                'field_widget_edit' => TRUE,
                'field_widget_remove' => TRUE,
                'open' => TRUE,
                'selection_mode' => 'selection_append',
                'field_widget_display_settings' => [
                  'view_mode' => 'default',
                ],
                'field_widget_replace' => FALSE,
              ],
              'type' => 'entity_browser_entity_reference',
              'weight' => 3,
            ])
            ->setDisplayOptions('view', [
              'label' => 'hidden',
              'settings' => [
                'target_type' => 'media',
              ],
              'weight' => 3,
            ]);
        $fields['field_image'] = BaseFieldDefinition::create('image')
            ->setLabel(t('Image'))
            ->setDescription(t('Image field'))
            ->setSettings([
              'file_directory' => 'IMAGE_FOLDER',
              'alt_field_required' => FALSE,
              'file_extensions' => 'png jpg jpeg',
            ])
           ->setDisplayOptions('view', array(
              'label' => 'hidden',
              'type' => 'default',
              'weight' => 0,
            ))
            ->setDisplayOptions('form', array(
              'label' => 'hidden',
              'type' => 'image_image',
              'weight' => 0,
            ))
            ->setCardinality(5)
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);
        $fields['uid'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('User Name'))
            ->setDescription(t('The Name of the associated user.'))
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('view', array(
            'label' => 'above',
            'type' => 'author',
            'weight' => -3,
        ))
        ->setDisplayOptions('form', array(
            'type' => 'entity_reference_autocomplete',
            'settings' => array(
            'match_operator' => 'CONTAINS',
            'size' => 60,
            'placeholder' => '',
            ),
            'weight' => -3,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);
        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'))
            ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'))
            ->setDescription(t('The time that the entity was last edited.'));
        return $fields;
    }
  }
