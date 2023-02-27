<?php

namespace MyTv\JournalBundle\Provider;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserProviderInterface
{
    public function getCurrentUser(): ?UserInterface;
}
