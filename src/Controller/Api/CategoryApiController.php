<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use App\Service\ValidationApiToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class CategoryApiController extends AbstractController
{
    /**
     * @Route("/category", methods={"GET"})
     */
    public function getCategoriesInformations(Request $request, CategoryRepository $categoryRepository, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];
        $token = $request->query->get('token');

        if ($user = $validationApiToken->isValidate($token)) {
            $categories = $categoryRepository->findAll();
            if ($categories && count($categories) > 0) {
                $data['success'] = true;
                
                foreach ($categories as $category) {
                    $data['data'][] = [
                        'id' => $category->getId(),
                        'title' => $category->getTitle(),
                        'promotion' => $category->getPromotion()->getTitle()
                    ];
                }
            }
        }
        return $this->json($data);
    }
}
