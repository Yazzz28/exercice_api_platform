<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CountPostController extends AbstractController
{
    public function __invoke(PostRepository $postRepository, Request $request): int
    {
        $online = $request->query->get('online', null);
        
        $condition = [];
        if ($online !== null) {
            $condition = ['online' => (bool) $online];
        }

        return $postRepository->count($condition);
    }
}