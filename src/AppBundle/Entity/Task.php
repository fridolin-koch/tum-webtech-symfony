<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 *
 * @author Fridolin Koch <info@fridokoch.de>
 *
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 * @ORM\HasLifecycleCallbacks
 */
class Task
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
     * @var TaskPriority
     *
     * @ORM\ManyToOne(targetEntity="TaskPriority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", nullable=false)
     */
    private $priority;

    /**
     * @var TaskType
     *
     * @ORM\ManyToOne(targetEntity="TaskType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @var TaskState
     *
     * @ORM\ManyToOne(targetEntity="TaskState")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=false)
     */
    private $state;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tasks")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $project;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dueDate;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $timeEstimated;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="task", orphanRemoval=true)
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $comments;

    /**
     * Init
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TaskPriority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param TaskPriority $priority
     *
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return TaskType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TaskType $type
     *
     * @return Task
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return TaskState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param TaskState $state
     *
     * @return Task
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return Task
     */
    public function setProject($project)
    {
        //add task to project
        $this->project = $project;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     *
     * @return Task
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @param \DateTime $modifiedDate
     *
     * @return Task
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeEstimated()
    {
        return $this->timeEstimated;
    }

    /**
     * @param int $timeEstimated
     *
     * @return Task
     */
    public function setTimeEstimated($timeEstimated)
    {
        $this->timeEstimated = $timeEstimated;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * @param ArrayCollection $activities
     *
     * @return Task
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     *
     * @return Task
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        $comment->setTask($this);
        $this->comments->add($comment);

        return $this;
    }

    /**
     * @param Comment $comment
     *
     * @return $this
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createDate = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->modifiedDate = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
