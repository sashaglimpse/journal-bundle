<?php

namespace MyTv\JournalBundle\Entity\Journal;

use MyTv\JournalBundle\Entity\EntityInterface;
use MyTv\JournalBundle\Repository\JournalSubjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalSubjectRepository::class)
 * @ORM\Table(name="core_journal_subjects")
 */
class Subject implements EntityInterface
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
    protected string $entityName;

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
    public function getEntityName(): string
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     */
    public function setEntityName(string $entityName): void
    {
        $this->entityName = $entityName;
    }
}
