<?php

namespace EmpaathyPress\Bundle\BookStoreBundle\Controller;

use EmpaathyPress\Bundle\BookStoreBundle\Entity\BookStore;
use EmpaathyPress\Bundle\BookStoreBundle\Helpers\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $dir = $this->get('kernel')->getRootDir() . "/../web";
        $book_id = $request->get("book_id", null);
        $em = $this->getDoctrine()->getManager();
        if ($request->get("book_id")) {
            $book = $em->getRepository('EmpaathyPressBookStoreBundle:BookStore')->findOneBy(array("id" => $request->get("book_id")));
        } else
            $book = new BookStore();
        $book_cover = $book->getBookCover();
        $book_filename = $book->getBookFilename();
        $form = $this->createFormBuilder($book, array('method' => 'PUT'))
            ->add("book_name", "text")
            ->add("book_cover", "file", array("attr" => array("accept" => ".png"), "data_class" => null))
            ->add("book_author", "text")
            ->add("book_filename", "file", array("attr" => array("accept" => ".pdf"), "data_class" => null))
            ->add("book_price", "integer")
            ->add("book_desc", "textarea")
            ->add("book_category", "entity", array(
                'class' => 'EmpaathyPressBookStoreBundle:BookCategory',
            ))
            ->getForm();

        if ($request->isMethod('PUT')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                if ($form['book_cover']->getData()) {
                    $CoverFilename = uniqid(rand(), true) . ".png";
                    $form['book_cover']->getData()->move($dir . "/uploads/book_cover", $CoverFilename);
                    $book->setBookCover($CoverFilename);
                } else {
                    $book->setBookCover($book_cover);
                }
                if ($form['book_filename']->getData()) {
                    $BookFilename = uniqid(rand(), true) . ".pdf";
                    $form['book_filename']->getData()->move($dir . "/uploads/book_pdf", $BookFilename);
                    $book->setBookFilename($BookFilename);
                } else {
                    $book->setBookFilename($book_filename);
                }

                $em->persist($book);
                $em->flush();
                return $this->redirect($this->generateUrl('home', array("page" => $request->get("page", 1))));
            }

        }


        ////

        $books_resp = $em->getRepository('EmpaathyPressBookStoreBundle:BookStore');
        // our custom paginator
        $paginator = new Paginator();

        // this is the query for listing
        $queryProcesses = $books_resp->getProcessesNativeQuery();

        // paginating
        $pagination = $paginator->paginate($queryProcesses,
            // page, default 1
            $this->get('request')->query->get('page', 1),
            // how many results per page, taken from parameters (so we won't hardcode)
            $this->container->getParameter('pagination_limit_page'));

        // finally, preparing the view


        return array(
            'pagination' => $pagination,
            'paginator' => $paginator,
            'cover' => $book_cover,
            'file_name' => $book_filename,
            "book_id" => $book_id,
            "book_form" => $form->createView());
    }

    /**
     * @Route("/delete_book", name="delete_book")
     * @Template()
     */
    public function deleteAction(Request $request)
    {
        /* @var $book BookStore */
        /* @var $em EntityManager */
        $dir = $this->get('kernel')->getRootDir() . "/../web";

        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('EmpaathyPressBookStoreBundle:BookStore')->findOneBy(array("id" => $request->get("book_id")));

        if (file_exists($dir . "/uploads/book_cover/" . $book->getBookCover())&&trim($book->getBookCover())!="")
            unlink($dir . "/uploads/book_cover/" . $book->getBookCover());
        if (file_exists($dir . "/uploads/book_pdf/" . $book->getBookFilename())&&trim($book->getBookFilename())!="")
            unlink($dir . "/uploads/book_pdf/" . $book->getBookFilename());

        $em->remove($book);
        $em->flush();
        return $this->redirect($this->generateUrl('home', array("page" => $request->get("page", 1))));
    }
}
