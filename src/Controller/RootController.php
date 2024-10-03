<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RootController extends AbstractController
{
    #[Route('/api', name: 'app_api', methods: ['GET'])]
    public function serverStatus(Request $request): Response
    {
        $data = [
            'status' => 'server is running',
            'host' => $request->getHost(),
            'protocol' => $request->getScheme()
        ];
        return $this->json($data);
    }

    #[Route('/api/ping', name: 'app_ping', methods: ['GET'])]
    public function ping(): Response
    {
        return $this->json(['status' => 'pong']);
    }
}