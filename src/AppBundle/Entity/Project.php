<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Project
 *
 * @author Fridolin Koch <info@fridokoch.de>
 *
 * @ORM\Entity
 * @ORM\Table("projects")
 * @UniqueEntity("name")
 * @UniqueEntity("id")
 */
class Project
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Regex(
     *  pattern="/^[a-z0-9-_]+$/",
     *  message="The project identifier may only contain alphanumeric characters, dashes and underscores"
     * )
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $customer;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Task", mappedBy="project")
     * @ORM\OrderBy({"modifiedDate" = "ASC"})
     */
    private $tasks;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     *
     * @return Project
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task)
    {
        $task->setProject($this);
        $this->tasks->add($task);

        return $this;
    }

    /**
     * @param Task $task
     *
     * @return $this
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
