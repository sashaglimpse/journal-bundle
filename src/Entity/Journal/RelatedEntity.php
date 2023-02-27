<?php

namespace MyTv\JournalBundle\Entity\Journal;

use MyTv\JournalBundle\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="core_journal_related_records")
 */
class RelatedEntity implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Record::class, inversedBy="relatedRecords")
     * @ORM\JoinColumn(nullable=false)
     * @var Record
     */
    protected Record $record;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class)
     * @ORM\JoinColumn(nullable=true)
     * @var Subject
     */
    private Subject $subject;

    /**
     * @ORM\Column(length=100)
     * @var string
     */
    protected string $relatedEntityId;

    public function __construct(Record $record, Subject $subject, string $relatedEntityId)
    {
        $this->record = $record;
        $this->subject = $subject;
        $this->relatedEntityId = $relatedEntityId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Record
     */
    public function getRecord(): Record
    {
        return $this->record;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getRelatedEntityId(): string
    {
        return $this->relatedEntityId;
    }
}
