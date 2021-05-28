<?php

namespace App\Controller\Api;

use App\Service\ValidationApiToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class UserApiController extends AbstractController
{
    /**
     * @Route("/user", methods={"GET"})
     */
    public function getUserInformations(Request $request, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];
        $token = $request->query->get('token');

        if ($user = $validationApiToken->isValidate($token)) {
            $data['success'] = true;
            $data['data'] = [
                'id' => $user->getId(),
                'username' => $user->getUsername()
            ];
        } 
        
        return $this->json($data);
    }
}
