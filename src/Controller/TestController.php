<?php


// src/Controller/TestController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Import the User entity
use App\Entity\User;
// Import the Password Encoder Interface
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestController extends AbstractController
{
    /**
     * @Route("/register_test", name="test_register_user")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(UserPasswordEncoderInterface $passwordEncoder)
    {
        // Retrieve the entity manager
        $entityManager = $this->getDoctrine()->getManager();

        // Create a new user with random data
        $user = new User();
        $user
            ->setEmail("dev@ourcodeworld.com")
            ->setPassword($passwordEncoder->encodePassword(
                $user,
                'MyTestPassword'
            ))
            ->setFirstName("Carlos")
            ->setLastName("Delgado");

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response(
            '<html><body>Test User Registered Succesfully</body></html>'
        );
    }
}