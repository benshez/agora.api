<?php
/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Modules\Base\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
