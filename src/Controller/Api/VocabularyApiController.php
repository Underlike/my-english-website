<?php

namespace App\Controller\Api;

use App\Repository\VocabularyRepository;
use App\Repository\CategoryRepository;
use App\Service\ValidationApiToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class VocabularyApiController extends AbstractController
{
    /**
     * @Route("/vocabulary", methods={"GET"})
     */
    public function getVocabularies(Request $request, CategoryRepository $categoryRepository, VocabularyRepository $vocabularyRepository, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];
        $token = $request->query->get('token');
        $categoryId = (int) $request->query->get('category_id');

        if ($user = $validationApiToken->isValidate($token)) {
            if ($category = $categoryRepository->find($categoryId)) {
                $vocabularies = $vocabularyRepository->findBy([
                    'category' => $category
                ]);
    
                if ($vocabularies && count($vocabularies) > 0) {
                    $data['success'] = true;
    
                    foreach ($vocabularies as $vocabulary) {
                        $data['data'] = [
                            'id' => $vocabulary->getId(),
                            'french' => $vocabulary->getFrench(),
                            'english' => $vocabulary->getEnglish(),
                            'english_wrong_one' => $vocabulary->getEnglishWrongOne(),
                            'english_wrong_two' => $vocabulary->getEnglishWrongTwo(),
                            'english_wrong_three' => $vocabulary->getEnglishWrongThree(),
                        ];
                    }
                }
            }            
        } 
        return $this->json($data);
    }
}
