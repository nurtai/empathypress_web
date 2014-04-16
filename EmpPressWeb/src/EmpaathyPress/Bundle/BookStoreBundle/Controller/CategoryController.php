<?php

namespace EmpaathyPress\Bundle\BookStoreBundle\Controller;

use EmpaathyPress\Bundle\BookStoreBundle\Entity\BookCategory;
use EmpaathyPress\Bundle\BookStoreBundle\Entity\BookStore;
use EmpaathyPress\Bundle\BookStoreBundle\Helpers\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $book_id = $request->get("category_id", null);
        $em = $this->getDoctrine()->getManager();
        if ($request->get("category_id")) {
            $book = $em->getRepository('EmpaathyPressBookStoreBundle:BookCategory')->findOneBy(array("id" => $request->get("category_id")));
        } else
            $book = new BookCategory();

        $form = $this->createFormBuilder($book, array('method' => 'PUT'))
            ->add("name", "text")
            ->getForm();

        if ($request->isMethod('PUT')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($book);
                $em->flush();
                return $this->redirect($this->generateUrl('category', array("page" => $request->get("page", 1))));
            }

        }


        ////

        $books_resp = $em->getRepository('EmpaathyPressBookStoreBundle:BookCategory');
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
            "book_form" => $form->createView());
    }

    /**
     * @Route("/delete_category", name="delete_category")
     * @Template()
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('EmpaathyPressBookStoreBundle:BookCategory')->findOneBy(array("id" => $request->get("category_id")));
        $em->remove($category);
        $em->flush();
        return $this->redirect($this->generateUrl('category', array("page" => $request->get("page", 1))));
    }

    /**
     * @Route("/category/data", name="category_data")
     * @Template()
     */
    public function getCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('EmpaathyPressBookStoreBundle:BookCategory')->findAll();
        $data=array();

        foreach ($category as $c) {
            /* @var $c BookCategory*/
            $a['id']=$c->getId();
            $a['name']=$c->getName();
            $data[]=$a;
        }
        $response=new JsonResponse();
        $response->setContent(json_encode($data,JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return  $response;
    }

    /**
     * @Route("/books/data", name="books_data")
     * @Template()
     */
    public function getBooksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('EmpaathyPressBookStoreBundle:BookStore')->findAll();
        $data=array();

        foreach ($category as $c) {
            /* @var $c BookStore*/
            $a['id']=$c->getId();
            $a['name']=$c->getBookName();
            $a['cover']=$c->getBookCover();
            $a['author']=$c->getBookAuthor();
            $a['desc']=$c->getBookDesc();
            $a['price']=$c->getBookPrice();
            $a['file']=$c->getBookFilename();
            $a['category_id']=$c->getBookCategory()->getId();
            $data[]=$a;
        }
        $response=new JsonResponse();
        $response->setContent(json_encode($data,JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return  $response;
    }
}
