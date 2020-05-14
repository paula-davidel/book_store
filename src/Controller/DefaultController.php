<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function showIndex()
    {
        return $this->render("book/author.html.twig");
    }
}