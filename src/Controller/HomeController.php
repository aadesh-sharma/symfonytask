<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([
            'status' => 'active'
        ]);
        return $this->render('home/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/{id}", name="show_post")
     */
    public function show_post($id, Request $request, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($id);
        return $this->render('home/index.html.twig', [
            'posts' => $post
        ]);
    }
}