<?php

namespace Drupal\pdf;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface NoteStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Note revision IDs for a specific Note.
   *
   * @param \Drupal\pdf\Entity\NoteInterface $entity
   *   The Note entity.
   *
   * @return int[]
   *   Note revision IDs (in ascending order).
   */
  public function revisionIds(NoteInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Note author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Note revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\pdf\Entity\NoteInterface $entity
   *   The Note entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(NoteInterface $entity);

  /**
   * Unsets the language for all Note with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
