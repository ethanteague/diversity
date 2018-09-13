<?php

namespace Drupal\legal\Plugin\migrate\source\d7;

use Drupal\migrate\Row;
use Drupal\migrate_drupal\Plugin\migrate\source\DrupalSqlBase;

/**
 * Drupal 7 source plugin for Legal T&Cs.
 *
 * @MigrateSource(
 *   id = "d7_legal_accepted",
 *   source_module = "legal",
 * )
 */
class LegalAccepted extends DrupalSqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {

    $query = $this->select('legal_accepted', 'a')
      ->fields('a')
      ->orderBy('a.legal_id');

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {

    $fields = [
      'legal_id'  => $this->t('Legal ID'),
      'version'  => $this->t('Version'),
      'revision'  => $this->t('Revision'),
      'language'  => $this->t('Language'),
      'uid'  => $this->t('User ID'),
      'accepted'  => $this->t('Accepted Date'),
      'tc_id'  => $this->t('T&C ID'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['legal_id']['type'] = 'integer';
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $id = $row->getSourceProperty('tc_id');

    $conditions = \Drupal::entityTypeManager()->getStorage('legal_conditions')->load($id);
    $uuid = $conditions->uuid();

    $row->setSourceProperty('uuid', $uuid);

    return parent::prepareRow($row);
  }

}
