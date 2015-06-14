<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 14/06/15
 * Time: 22:16
 */

namespace dElt4\SynthesisBundle\Manager;


use dElt4\TimeBundle\Entity\Event;
use dElt4\TimeBundle\Entity\ProjectHasUser;

class ReportingManager {
    public function renderReport(array $results, array $data)
    {
        $reporting = array();
        if (count($results) > 0) {
            $reporting['project'] = array(
                'title' => $data['project']->getTitle(),
                'price' => $data['project']->getPrice(),
            );
            foreach ($results as $event) {
                if ($event instanceof Event) {
                    if (!isset($reporting['users']) || !array_key_exists($event->getUser()->getId(), $reporting['users'])) {
                        $reporting['users'][$event->getUser()->getId()] = array(
                            'name' => $event->getUser()->__toString(),
                            'price' => $this->getUserCost($event),
                            'id' => $event->getUser()->getId(),
                            'nbDays' => 0
                        );
                    }
                    $reporting['users'][$event->getUser()->getId()]['nbDays']++;
                }
            }
        }

        return $reporting;
    }

    private function getUserCost(Event $event) {

        foreach ($event->getProject()->getProjectHasUsers() as $projectHasUser) {
            if ($projectHasUser instanceof ProjectHasUser) {
                if ($projectHasUser->getUser()->getId() === $event->getUser()->getId()) {
                    return $projectHasUser->getCostPerDay();
                }
            }
        }
    }
} 