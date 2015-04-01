<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ActivityType;
use AppBundle\Entity\TaskPriority;
use AppBundle\Entity\TaskState;
use AppBundle\Entity\TaskType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load default data
 *
 * @author Fridolin Koch <info@fridokoch.de>
 */
class LoadDefaultData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //define task priories
        $priorities = [
            ['Low', '#FFF'],
            ['Normal', '#FFF'],
            ['High', '#FFF'],
            ['Urgend', '#FFF'],
        ];
        //create all priorities
        foreach ($priorities as $priority) {
            $obj = new TaskPriority();
            $obj
                ->setName($priority[0])
                ->setColor($priority[1]);

            $manager->persist($obj);
        }

        //define task states
        $states = [
            ['New', '#FFF'],
            ['In Progress', '#FFF'],
            ['Resolved', '#FFF'],
            ['Feedback', '#FFF'],
            ['Closed', '#FFF'],
            ['Rejected', '#FFF'],
        ];
        //create all priorities
        foreach ($states as $state) {
            $obj = new TaskState();
            $obj
                ->setName($state[0])
                ->setColor($state[1]);

            $manager->persist($obj);
        }

        //define task types
        $types = [
            ['Bug', '#FFF'],
            ['Feature', '#FFF'],
            ['Task', '#FFF'],
        ];
        //create all types
        foreach ($types as $type) {
            $obj = new TaskType();
            $obj
                ->setName($type[0])
                ->setColor($type[1]);

            $manager->persist($obj);
        }

        //define activity types
        $activityTypes = [
            'Development',
            'Design',
            'Support'
        ];
        //create all activity types
        foreach ($activityTypes as $type) {
            $obj = new ActivityType();
            $obj->setName($type);

            $manager->persist($obj);
        }

        //write all changes to database
        $manager->flush();
    }
}
