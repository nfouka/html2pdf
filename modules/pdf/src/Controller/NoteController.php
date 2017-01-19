<?php

namespace Drupal\pdf\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\pdf\Entity\NoteInterface;

/**
 * Class NoteController.
 *
 *  Returns responses for Note routes.
 *
 * @package Drupal\pdf\Controller
 */
class NoteController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Note  revision.
   *
   * @param int $note_revision
   *   The Note  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($note_revision) {
    $note = $this->entityManager()->getStorage('note')->loadRevision($note_revision);
    $view_builder = $this->entityManager()->getViewBuilder('note');

    return $view_builder->view($note);
  }

  /**
   * Page title callback for a Note  revision.
   *
   * @param int $note_revision
   *   The Note  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($note_revision) {
    $note = $this->entityManager()->getStorage('note')->loadRevision($note_revision);
    return $this->t('Revision of %title from %date', array('%title' => $note->label(), '%date' => format_date($note->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Note .
   *
   * @param \Drupal\pdf\Entity\NoteInterface $note
   *   A Note  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(NoteInterface $note) {
    $account = $this->currentUser();
    $langcode = $note->language()->getId();
    $langname = $note->language()->getName();
    $languages = $note->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $note_storage = $this->entityManager()->getStorage('note');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $note->label()]) : $this->t('Revisions for %title', ['%title' => $note->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all note revisions") || $account->hasPermission('administer note entities')));
    $delete_permission = (($account->hasPermission("delete all note revisions") || $account->hasPermission('administer note entities')));

    $rows = array();

    $vids = $note_storage->revisionIds($note);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\pdf\NoteInterface $revision */
      $revision = $note_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $note->getRevisionId()) {
          $link = $this->l($date, new Url('entity.note.revision', ['note' => $note->id(), 'note_revision' => $vid]));
        }
        else {
          $link = $note->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('note.revision_revert_translation_confirm', ['note' => $note->id(), 'note_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('note.revision_revert_confirm', ['note' => $note->id(), 'note_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('note.revision_delete_confirm', ['note' => $note->id(), 'note_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['note_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
