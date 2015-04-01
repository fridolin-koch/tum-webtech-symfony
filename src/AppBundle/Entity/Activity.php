<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Activity
 *
 * @author Fridolin Koch <info@fridokoch.de>
 *
 * @ORM\Entity
 * @ORM\Table(name="activities")
 */
class Activity
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ActivityType
     *
     * @ORM\ManyToOne(targetEntity="ActivityType")
     * @ORM\JoinColumn(name="activity_type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var Task
     *
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="activities")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    private $task;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $timeSpent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Activity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return ActivityType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ActivityType $type
     *
     * @return Activity
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @param Task $task
     *
     * @return Activity
     */
    public function setTask($task)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Activity
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * @param int $timeSpent
     *
     * @return Activity
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->timeSpent . '@' . $this->type;
    }
}
