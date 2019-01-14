<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $finished = false;

    /**
     * @ORM\Column(type="datetime_immutable", name="created_at", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", name="updated_at", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

    public function __construct($body, \DateTimeImmutable $createdAt, User $user)
    {
        $this->body = $body;
        $this->createdAt = $createdAt;
        $this->updatedAt = $createdAt;
        $this->user = $user;
    }

    /**
     * @param string $body
     */
    public function edit($body)
    {
        $this->body= $body;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if ($status) {
            $this->finish();
        }
        else $this->open();
    }

    public function open()
    {
        $this->finished = false;
    }

    public function finish()
    {
        $this->finished = true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->finished ? 'Выполнен' : 'Не выполнен';
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'body' => $this->getBody(),
            'finished' => $this->isFinished(),
            'statusText' => $this->getStatusText(),
            'user' => $this->getUser()->toArray(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i'),
        ];
    }
}
