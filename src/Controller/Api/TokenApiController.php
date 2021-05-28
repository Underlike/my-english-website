<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TokenApiController extends AbstractController
{
    /**
     * @Route("/token/api", name="token_api")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository): Response
    {
        $data = ['success' => false];
        $username = $request->get('username');
        $password = $request->get('password');

        if ($username && $password) {
            $user = $userRepository->findOneBy([
                'username' => $username
            ]);

            if ($user) {
                $passwordVerify = $passwordEncoder->isPasswordValid(
                    $user,
                    $password
                );

                if ($passwordVerify) {
                    $data['success'] = true;
                    $data['token'] = $user->getApiToken();
                }
            }
        }
        return $this->json($data);
    }
}
