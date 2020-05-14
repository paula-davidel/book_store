<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Books;


class BookController extends AbstractController
{

    /**
     * @Route("/books", name="display_books")
     */
    public function displayAction()
    {
        $books = $this->getDoctrine()->getRepository(Books::class)->findAll();
        $data = array(
            "books" => $books
        );

        return $this->render("book/display.html.twig",$data);

    }

    /**
     * @Route("/books/new", name="new_book")
     */
    public function newAction(Request $request)
    {

        $book = new Books();
        $form = $this->createFormBuilder($book)
            ->add('name', TextType::class)
            ->add('author', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();

            // tells Doctrine you want to save the Product
            $doct->persist($book);

            //executes the queries (i.e. the INSERT query)
            $doct->flush();

            return $this->redirectToRoute('display_books');
        } else {
            return $this->render('book/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
    /**
     * @Route("/books/update/{id}", name = "update_book" )
     */
    public function updateAction($id, Request $request) {
        $doct = $this->getDoctrine()->getManager();
        $bk = $doct->getRepository(Books::class)->find($id);

        if (!$bk) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $form = $this->createFormBuilder($bk)
            ->add('name', TextType::class)
            ->add('author', TextType::class)
            ->add('price', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $doct = $this->getDoctrine()->getManager();

            // tells Doctrine you want to save the Product
            $doct->persist($book);

            //executes the queries (i.e. the INSERT query)
            $doct->flush();
            return $this->redirectToRoute('display_books');
        } else {
            return $this->render('book/new.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

    /**
     * @Route("/books/delete/{id}", name="delete_book")
     */
    public function deleteAction($id) {
        $doct = $this->getDoctrine()->getManager();
        $bk = $doct->getRepository(Books::class)->find($id);

        if (!$bk) {
            throw $this->createNotFoundException('No book found for id '.$id);
        }
        $doct->remove($bk);
        $doct->flush();
        return $this->redirectToRoute('display_books');
    }
}
