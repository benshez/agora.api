<?php

namespace Agora\Modules\Base\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Agora\Bundles\Users\Entity\Users;
use Zend\Crypt\Password\BcryptSha;

class UserFixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $bcrypt = new BcryptSha();
        $user = new User();
        $user->setUsername('admin');
        $user->setRole('1');
        $user->setPassword($bcrypt->create('password'));
        $user->setSalt('salt');
        $user->setLocked('0');
        $user->setEnabled('1');
        $user->setExpiresAt($this->getFormattedDate());
        $user->setLastLogin($this->getFormattedDate());

        $manager->persist($user);
        $manager->flush();
    }

    private function getFormattedDate()
    {
        $date = new \DateTime();
        return '\'' . $date->format('Y-m-d') . '\'';
    }
}
