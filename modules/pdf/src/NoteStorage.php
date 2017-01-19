<?php

namespace Drupal\pdf;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\pdf\Entity\NoteInterface;

/**
 * Defines the storage handler class for Note entities.
 *
 * This extends the base storage class, adding required special handling for
 * Note entities.
 *
 * @ingroup pdf
 */
class NoteStorage extends SqlContentEntityStorage implements NoteStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(NoteInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {note_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {note_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(NoteInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {note_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('note_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
