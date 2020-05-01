<?php

namespace App\Controller;

use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return JsonResponse
     */
    public function login(AuthenticationUtils $authenticationUtils): JsonResponse
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            return new JsonResponse('Login Failed', Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse('Login Success', Response::HTTP_OK);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws Exception
     */
    public function logout(): void
    {
        throw new RuntimeException('This will be intercepted by the logout key');
    }

    /**
     * @Route("/session-status", name="app_session_status", methods={"GET"})
     * @param Security $security
     * @return JsonResponse
     */
    public function sessionStatus(Security $security): JsonResponse
    {
        $user = $security->getUser();
        $id = $user->getId();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();

        $data =
            [
                'active' => true,
                'id' => $id,
                'firstName' => $firstName,
                'lastName' => $lastName
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}