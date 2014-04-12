<?php
/**
 * Created by PhpStorm.
 * User: nurtai
 * Date: 4/8/14 AD
 * Time: 11:28 PM
 */

namespace EmpaathyPress\Bundle\BookStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EmpaathyPress\Bundle\BookStoreBundle\Entity\MyBooksRepository")
 * @ORM\Table(name="book_my_books")
 */
class myBooksCategory {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $book_name;

    /**
     * @ORM\OneToMany(targetEntity="BookStore", mappedBy="book_category")
     */

    protected $category_books;
} 