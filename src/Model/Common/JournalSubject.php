<?php

namespace MyTv\JournalBundle\Model\Common;

class JournalSubject
{
    private string $subjectCode;
    private string $entityId;

    /**
     * @param string $subjectCode
     * @param string $entityId
     */
    public function __construct(string $subjectCode, string $entityId)
    {
        $this->subjectCode = $subjectCode;
        $this->entityId = $entityId;
    }

    /**
     * @return string
     */
    public function getSubjectCode(): string
    {
        return $this->subjectCode;
    }

    /**
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }
}
