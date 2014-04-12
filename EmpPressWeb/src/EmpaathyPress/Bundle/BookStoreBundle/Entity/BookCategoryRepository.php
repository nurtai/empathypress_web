<?php
/**
 * Created by PhpStorm.
 * User: nurtai
 * Date: 4/8/14 AD
 * Time: 11:33 PM
 */

namespace EmpaathyPress\Bundle\BookStoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\Query\ResultSetMappingBuilder;
class BookCategoryRepository extends EntityRepository {

    public function getProcessesNativeQuery()
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('EmpaathyPress\Bundle\BookStoreBundle\Entity\BookCategory', 'b');

        $q = $this->getEntityManager()
            ->createNativeQuery('select * from book_category b', $rsm);

        return $q;
    }
} 