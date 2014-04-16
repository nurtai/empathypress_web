<?php
/**
 * Created by PhpStorm.
 * User: nurtai
 * Date: 4/9/14 AD
 * Time: 3:16 PM
 */

namespace EmpaathyPress\Bundle\BookStoreBundle\DataFixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use EmpaathyPress\Bundle\BookStoreBundle\Entity\BookCategory;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

use EmpaathyPress\Bundle\BookStoreBundle\Entity\User;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Doctrine\ORM\EntityManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        $cat1=new BookCategory();
        $cat1->setName("Category1");

        $cat2=new BookCategory();
        $cat2->setName("Category2");

        $cat3=new BookCategory();
        $cat3->setName("Category3");

        $manager->persist($cat1);
        $manager->persist($cat2);
        $manager->persist($cat3);

        $manager->flush();


    }
}