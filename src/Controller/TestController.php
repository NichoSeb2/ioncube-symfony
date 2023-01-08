<?php

namespace App\Controller;

use App\Service\TestIoncube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(TestIoncube $testIoncube): JsonResponse
    {
        return $this->json([
            'message' => $testIoncube->test(),
        ]);
    }
}
