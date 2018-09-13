<?php

namespace Drupal\Tests\Traits;

use \PHPUnit\Framework\Assert;

/**
 * Provides methods to create node based on default settings.
 *
 * This trait is meant to be used only by test classes.
 */
trait FieldTrait {

  /**
   * The $field_name field should be required for $node_type.
   */
  public function isRequiredField($field_name, $node_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('node', $node_type);
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * The $field_name field should not be required for $node_type.
   */
  public function isNotRequiredField($field_name, $node_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('node', $node_type);
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * The $field_name on $node_type should allow refs to $reference_bundles.
   */
  public function fieldAllowsEntityReferences($field_name, $node_type, array $reference_bundles) {
    foreach ($reference_bundles as $reference_bundle) {
      $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('node', $node_type);
      $field_definition = $bundle_fields[$field_name];
      $settings = $field_definition->getSettings();
      $target_bundles = $settings['handler_settings']['target_bundles'];
      Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle) . ' content');
    }
  }
  
  /**
   * The $field_name should be present on $entity_type $bundle.
   */
  public function isField($field_name, $bundle, $entity_type) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions($bundle, $entity_type);
    if (empty($bundle_fields[$field_name])) {
      \Assert::assertEmpty($bundle_fields, $field_name . ' is not present on the ' . $entity_type . " " . $bundle);
    }
  }
}
