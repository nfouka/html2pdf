<?php

namespace Drupal\pdf\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Note entities.
 *
 * @ingroup pdf
 */
interface NoteInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Note name.
   *
   * @return string
   *   Name of the Note.
   */
  public function getName();

  /**
   * Sets the Note name.
   *
   * @param string $name
   *   The Note name.
   *
   * @return \Drupal\pdf\Entity\NoteInterface
   *   The called Note entity.
   */
  public function setName($name);

  /**
   * Gets the Note creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Note.
   */
  public function getCreatedTime();

  /**
   * Sets the Note creation timestamp.
   *
   * @param int $timestamp
   *   The Note creation timestamp.
   *
   * @return \Drupal\pdf\Entity\NoteInterface
   *   The called Note entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Note published status indicator.
   *
   * Unpublished Note are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Note is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Note.
   *
   * @param bool $published
   *   TRUE to set this Note to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\pdf\Entity\NoteInterface
   *   The called Note entity.
   */
  public function setPublished($published);

  /**
   * Gets the Note revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Note revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\pdf\Entity\NoteInterface
   *   The called Note entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Note revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Note revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\pdf\Entity\NoteInterface
   *   The called Note entity.
   */
  public function setRevisionUserId($uid);

}
