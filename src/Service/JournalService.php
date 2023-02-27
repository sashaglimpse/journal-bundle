<?php

namespace MyTv\JournalBundle\Service;

use MyTv\JournalBundle\Entity\EntityInterface;
use MyTv\JournalBundle\Entity\Journal\Record;
use MyTv\JournalBundle\Entity\Journal\RelatedEntity;
use MyTv\JournalBundle\Entity\Journal\Subject;
use MyTv\JournalBundle\Provider\DateTimeProviderInterface;
use MyTv\JournalBundle\Provider\UserProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SystemJournalService
 * @package App\Service
 */
class JournalService
{
    public function __construct(
        private readonly DateTimeProviderInterface $dateTimeProvider,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserProviderInterface $currentUserProvider
    ) {
    }

    public function addJournalRecord(
        EntityInterface $subjectEntity,
        string $event,
        array $details = [],
        array $relatedEntities = []
    ): void {
        $user = $this->currentUserProvider->getCurrentUser();

        if (!($user instanceof UserInterface)) {
            $user = null;
        }

        $date = $this->dateTimeProvider->getCurrentDateTime();

        $record = new Record($this->findOrCreateSubject($subjectEntity), $details);
        $record->setUser($user);
        $record->setEvent($event);
        $record->setCreatedAt($date);
        $record->setEntityId((int) $subjectEntity->getId());

        $this->addRelatedEntities($record, $relatedEntities);

        $this->entityManager->persist($record);
        $this->entityManager->flush();
    }

    /**
     * @param EntityInterface $subjectEntity
     *
     * @return Subject
     */
    protected function findOrCreateSubject(EntityInterface $subjectEntity): Subject
    {
        $className = $this->entityManager->getClassMetadata(get_class($subjectEntity))->name;
        $subject = $this->entityManager->getRepository(Subject::class)->findOneBy(['entityName' => $className]);

        if (null === $subject) {
            $subject = new Subject();
            $subject->setEntityName($className);
            $this->entityManager->persist($subject);
        }

        return $subject;
    }

    protected function addRelatedEntities(Record $record, array $relatedEntities): void
    {
        foreach ($relatedEntities as $entity) {
            if (!($entity instanceof EntityInterface)) {
                throw new \LogicException(
                    sprintf(
                        'RelatedEntity provided for System Journal doesn\'t implement EntityInterface. Got "%s"',
                        is_object($entity) ? get_class($entity) : gettype($entity)
                    )
                );
            }

            $subject = $this->findOrCreateSubject($entity);
            $relatedEntity = new RelatedEntity($record, $subject, (string) $entity->getId());
            $record->getRelatedRecords()->add($relatedEntity);
        }
    }
}
