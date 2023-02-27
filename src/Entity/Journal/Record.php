<?php

namespace MyTv\JournalBundle\Entity\Journal;

use MyTv\JournalBundle\Entity\EntityInterface;
use MyTv\JournalBundle\Repository\JournalRecordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=JournalRecordRepository::class)
 * @ORM\Table(name="core_journal_records")
 */
class Record implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column()
     */
    protected string $event;

    /**
     * @ORM\Column(type="json")
     */
    protected array $details;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $entityId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true)
     */
    protected ?UserInterface $user;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected Subject $subject;

    /**
     * @ORM\Column(type="datetime")
     */
    protected \DateTime $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=RelatedEntity::class, cascade={"REMOVE", "PERSIST"}, mappedBy="record")
     * @var Collection<int, RelatedEntity>
     */
    protected Collection $relatedRecords;

    public function __construct(Subject $subject, ?array $details)
    {
        $this->subject = $subject;
        $this->details = $details ?? [];
        $this->relatedRecords = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param array $details
     */
    public function setDetails(array $details): void
    {
        $this->details = $details;
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @param int $entityId
     */
    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     */
    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    /**
     * @return Collection<int, RelatedEntity>
     */
    public function getRelatedRecords(): Collection
    {
        return $this->relatedRecords;
    }
}
