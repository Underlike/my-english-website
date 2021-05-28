<?php

namespace App\Controller\Api;

use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Repository\CategoryRepository;
use App\Service\ValidationApiToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class SessionApiController extends AbstractController
{
    /**
     * @Route("/session", methods={"POST"})
     */
    public function setNewSession(Request $request, CategoryRepository $categoryRepository, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];
        $token = $request->get('token');
        $categoryId = (int) $request->get('category_id');

        if ($user = $validationApiToken->isValidate($token)) {
            if ($category = $categoryRepository->find($categoryId)) {
                $newSession = new Session();
                $newSession->setUser($user);
                $newSession->setScore(0);
                $newSession->setRound(0);
                $newSession->setIsFinish(false);
                $newSession->setCategory($category);
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newSession);
                $entityManager->flush();
    
                $data['success'] = true;
                $data['data'] = [
                    'id' => $newSession->getId()
                ];
            }
        }
        return $this->json($data);
    }

    /**
     * @Route("/session/score", methods={"POST"})
     */
    public function setScoreSession(Request $request, SessionRepository $sessionRepository, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];

        $id = (int) $request->get('id');
        $token = $request->get('token');
        $correct = (bool) $request->get('correct');

        if ($user = $validationApiToken->isValidate($token) && $id) {
            $session = $sessionRepository->find($id);

            if ($session && ($session->getUser()->getApiToken() == $token)) {
                $score = $session->getScore();
                $round = $session->getRound();

                if ($round <= 49) {
                    $session->setRound($round + 1);

                    if ($correct) {
                        $session->setScore($score + 1);
                    }
                } else {
                    $session->setIsFinish(true);
                }
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($session);
                $entityManager->flush();

                $data['success'] = true;
                $data['data'] = [
                    'id' => $session->getId(),
                    'score' => $session->getScore(),
                    'round' => $session->getRound(),
                    'is_finish' => $session->getIsFinish()
                ];
            }
        }
        return $this->json($data);
    }

    /**
     * @Route("/sessions", methods={"GET"})
     */
    public function getSessions(Request $request, SessionRepository $sessionRepository, ValidationApiToken $validationApiToken): Response
    {
        $data = ['success' => false];
        $token = $request->query->get('token');

        if ($user = $validationApiToken->isValidate($token)) {
            $sessions = $sessionRepository->findBy([
                'user' => $user
            ]);

            if ($sessions && count($sessions) > 0) {
                $data['success'] = true;

                foreach ($sessions as $session) {
                    $data['data'][] = [
                        'id' => $session->getId(),
                        'is_finish' => $session->getIsFinish(),
                        'score' => $session->getScore(),
                        'round' => $session->getRound(),
                        'category' => $session->getCategory()->getTitle()
                    ];
                }
            }
        }
        return $this->json($data);
    }
}
