<?php

namespace Drupal\lalg_utilities\Services;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\group\Entity\Group;

/**
 * Class GroupTasks.
 *
 * @package Drupal\lalg_utilities\Services
 */
class GroupTasks {

  /**
   * @var EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * @param EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * @return bool
   */
  public function isGroupArchived($gid): bool  {

    try {
	  $group = $this->entityTypeManager->getStorage('group')->load($gid);	  

	  if ($group->hasField('field_archived')) {
	     return $group->get('field_archived')->getString() === '1';
	  }
    } catch (InvalidPluginDefinitionException|PluginNotFoundException $e) {
    }
    return FALSE;
  }

    public function isGroupHidden($gid): bool  {

        try {
            $group = $this->entityTypeManager->getStorage('group')->load($gid);

            if ($group->hasField('field_group_type')) {
                $group_type = $group->get('field_group_type')->entity->label();
                $denote_hidden = array("Hidden", "Team");
                if (in_array($group_type, $denote_hidden )) {
                    return TRUE;
                }
            }
        } catch (InvalidPluginDefinitionException|PluginNotFoundException $e) {
        }
        return FALSE;
    }
}
