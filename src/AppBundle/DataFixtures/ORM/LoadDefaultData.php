<?php
namespace AppBundle\DataFixtures\ORM;

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
            ['Low', '#467edb'],
            ['Normal', '#000'],
            ['High', '#fe8a8a'],
            ['Urgend', '#f21f1f'],
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
            ['New', '#000'],
            ['In Progress', '#000'],
            ['Resolved', '#000'],
            ['Feedback', '#000'],
            ['Closed', '#000'],
            ['Rejected', '#000'],
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
            ['Bug'],
            ['Feature'],
            ['Task'],
        ];
        //create all types
        foreach ($types as $type) {
            $obj = new TaskType();
            $obj->setName($type[0]);

            $manager->persist($obj);
        }

        //write all changes to database
        $manager->flush();
    }
}
