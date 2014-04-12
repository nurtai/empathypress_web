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
 * @ORM\Entity(repositoryClass="EmpaathyPress\Bundle\BookStoreBundle\Entity\BookStoreRepository")
 * @ORM\Table(name="book_store")
 */
class BookStore {
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
     * @ORM\Column(type="string", length=200)
     */
    protected $book_cover;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $book_author;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $book_filename;

    /**
     * @ORM\Column(type="integer")
     */
    protected $book_price;

    /**
     * @ORM\Column(type="text")
     */
    protected $book_desc;

    /**
     * @ORM\ManyToOne(targetEntity="BookCategory", inversedBy="category_books")
     * @ORM\JoinColumn(name="boook_category_id", referencedColumnName="id")
     */
    protected $book_category;

    /**
     * @param mixed $book_author
     */
    public function setBookAuthor($book_author)
    {
        $this->book_author = $book_author;
    }

    /**
     * @return mixed
     */
    public function getBookAuthor()
    {
        return $this->book_author;
    }

    /**
     * @param mixed $book_category
     */
    public function setBookCategory($book_category)
    {
        $this->book_category = $book_category;
    }

    /**
     * @return mixed
     */
    public function getBookCategory()
    {
        return $this->book_category;
    }

    /**
     * @param mixed $book_cover
     */
    public function setBookCover($book_cover)
    {
        $this->book_cover = $book_cover;
    }

    /**
     * @return mixed
     */
    public function getBookCover()
    {
        return $this->book_cover;
    }

    /**
     * @param mixed $book_desc
     */
    public function setBookDesc($book_desc)
    {
        $this->book_desc = $book_desc;
    }

    /**
     * @return mixed
     */
    public function getBookDesc()
    {
        return $this->book_desc;
    }

    /**
     * @param mixed $book_filename
     */
    public function setBookFilename($book_filename)
    {
        $this->book_filename = $book_filename;
    }

    /**
     * @return mixed
     */
    public function getBookFilename()
    {
        return $this->book_filename;
    }

    /**
     * @param mixed $book_name
     */
    public function setBookName($book_name)
    {
        $this->book_name = $book_name;
    }

    /**
     * @return mixed
     */
    public function getBookName()
    {
        return $this->book_name;
    }

    /**
     * @param mixed $book_price
     */
    public function setBookPrice($book_price)
    {
        $this->book_price = $book_price;
    }

    /**
     * @return mixed
     */
    public function getBookPrice()
    {
        return $this->book_price;
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


} 