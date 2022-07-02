<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['GET', 'POST'])]
    public function index(Request $request, RequestStack $requestStack): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $params = $request->request->all();
            
            $session = $requestStack->getSession();
            $session->set('userParams', $params['user']);

            return $this->redirectToRoute('confirm');
        }

        return $this->renderForm('register.html.twig', ['form' => $form]);
    }

    #[Route('/confirm', name: 'confirm', methods: ['GET'])]
    public function confirm(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $params = $session->get('userParams');

        if (!$params) {
            return $this->renderForm(
                'register.html.twig', 
                ['form' => $this->createForm(UserType::class, new User())]
            );
        }

        return $this->renderForm(
            'confirm.html.twig',
            [
                'firstName' => $params['firstName'],
                'lastName' => $params['lastName'],
                'firstNameKana' => $params['firstNameKana'],
                'lastNameKana' => $params['lastNameKana'],
                'email' => $params['email'],
            ]
        );
    }

    #[Route('/complete', name: 'complete', methods: ['POST'])]
    public function complete(RequestStack $requestStack, ManagerRegistry $doctrine): Response
    {
        $session = $requestStack->getSession();
        $params = $session->get('userParams');
        $session->set('userParams', null);

        $user = (new User())
            ->setFirstName($params['firstName'])
            ->setLastName($params['lastName'])
            ->setFirstNameKana($params['firstNameKana'])
            ->setLastNameKana($params['lastNameKana'])
            ->setEmail($params['email'])
            ->setPassword($params['password'])
        ;

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->renderForm('complete.html.twig');
    }
}
