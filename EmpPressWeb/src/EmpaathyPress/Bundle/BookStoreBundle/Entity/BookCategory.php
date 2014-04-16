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
 * @ORM\Entity(repositoryClass="EmpaathyPress\Bundle\BookStoreBundle\Entity\BookCategoryRepository")
 * @ORM\Table(name="book_category")
 */
class BookCategory {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="BookStore", mappedBy="book_category")
     */

    protected $category_books;

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $category_books
     */
    public function setCategoryBooks($category_books)
    {
        $this->category_books = $category_books;
    }

    /**
     * @return mixed
     */
    public function getCategoryBooks()
    {
        return $this->category_books;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function __toString(){
        return $this->name;
    }

}