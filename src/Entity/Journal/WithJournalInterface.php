<?php

namespace MyTv\JournalBundle\Entity\Journal;

use MyTv\JournalBundle\Entity\EntityInterface;

interface WithJournalInterface extends EntityInterface
{
    public function getJournalRelatedEntities(): array;
}
