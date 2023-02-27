<?php

namespace MyTv\JournalBundle\Provider;

interface DateTimeProviderInterface
{
    public function getCurrentDateTime(bool $fresh = false): \DateTime;
}
