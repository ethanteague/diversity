<?php

namespace Drupal\Tests\Traits;

use Drupal\user\Entity\Role;
//use PHPUnit_Framework_Assert;
use \PHPUnit\Framework\Assert;

/**
 * Provides methods to create node based on default settings.
 *
 * This trait is meant to be used only by test classes.
 */
trait UserEntityTrait {

  /**
   * Get all user roles.
   */
  public function getRoles() {
    $roles = user_roles();
    $roles = array_keys($roles);
    return $roles;
  }

  /**
   * Users with the $role should have the $permission.
   */
  public function roleHasPermission($role, $permission) {
    $roleObj = Role::load($role);
    Assert::assertNotEmpty($roleObj->hasPermission($permission), $role . ' role does not have permission to ' . $permission);
  }

  /**
   * Users with the $role should not have the $permission.
   */
  public function roleDoesNotHavePermission($role, $permission) {
    $roleObj = Role::load($role);
    Assert::assertEmpty($roleObj->hasPermission($permission), $role . ' role has permission to ' . $permission . ', but should not.');
  }

  /**
   * Users with the $role should be able to create $node_type content.
   */
  public function roleCanCreateContent($role, $node_type) {
    $permission = 'create ' . $node_type . ' content';
    $this->roleHasPermission($role, $permission);
  }

  /**
   * Users with the $role should not be able to create $node_type content.
   */
  public function roleCanNotCreateContent($role, $node_type) {
    $permission = 'create ' . $node_type . ' content';
    $this->roleDoesNotHavePermission($role, $permission);
  }

  /**
   * The $field_name field should be required for users.
   */
  public function isRequiredUserField($field_name) {
    $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('user', 'user');
    $field_definition = $bundle_fields[$field_name];
    $setting = $field_definition->isRequired();
    Assert::assertNotEmpty($setting, 'Field ' . $field_name . ' is not required.');
  }

  /**
   * The $field_name on users should allow refs to $reference_bundles.
   */
  public function userFieldAllowsEntityReferences($field_name, array $reference_bundles) {
    foreach ($reference_bundles as $reference_bundle) {
      $bundle_fields = \Drupal::getContainer()->get('entity_field.manager')->getFieldDefinitions('user', 'user');
      $field_definition = $bundle_fields[$field_name];
      $settings = $field_definition->getSettings();
      $target_bundles = $settings['handler_settings']['target_bundles'];
      Assert::assertContains(trim($reference_bundle), $target_bundles, $field_name . ' does not allow references to ' . trim($reference_bundle) . ' content');
    }
  }

}
