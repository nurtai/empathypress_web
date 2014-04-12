<?php
/**
 * Created by PhpStorm.
 * User: nurtai
 * Date: 4/9/14 AD
 * Time: 3:08 PM
 */

namespace EmpaathyPress\Bundle\BookStoreBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use EmpaathyPress\Bundle\BookStoreBundle\Entity\Role;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\ORM\EntityManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load( ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setName('ROLE_USER');

        $role2 = new Role();
        $role2->setName('ROLE_ADMIN');

        $manager->persist($role1);
        $manager->persist($role2);

        $manager->flush();

        $this->addReference('role_user', $role1);
        $this->addReference('role_admin', $role2);
    }
}