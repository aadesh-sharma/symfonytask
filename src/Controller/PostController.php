<?php

namespace App\Controller;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
    * @Route("/dashboard/post", name="post")
    */
   public function index(PostRepository $postRepository): Response
   {
       return $this->render('post/index.html.twig', [
           'posts' => $postRepository->findAll(),
       ]);
   }

   /**
    * @Route("/dashboard/post/create", name="create_post")
    */

   public function create(Request $request){

    // if (!$this->getUser()) {
    //      return $this->redirectToRoute('app_login');
    //     }
       $post = new Post();
       
       $postForm = $this->createForm(PostType::class, $post);
       $postForm->handleRequest($request);

       if($postForm->isSubmitted() && $postForm->isValid()){
           $post->setSlug($this->slugify($post->getTitle()));
           $post->setPostStatus('active');
           $post->setAuthor($this->getUser()->getUsername());
           $post->setPostAuthor($this->getUser());
           $post->setCreated(new \DateTime());
           $post->setUpdated(new \DateTime());
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($post); // query prepared
           $entityManager->flush(); // execute query

           return $this->redirectToRoute('post');
       }

       return $this->render('post/create.html.twig', [
           'postForm' => $postForm->createView()
       ]);
   }


   private function slugify($text)
   {
       // replace non letter or digits by -
       $text = preg_replace('~[^\pL\d]+~u', '-', $text);

       // transliterate
       $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

       // remove unwanted characters
       $text = preg_replace('~[^-\w]+~', '', $text);

       // trim
       $text = trim($text, '-');

       // remove duplicate -
       $text = preg_replace('~-+~', '-', $text);

       // lowercase
       $text = strtolower($text);

       if (empty($text)) {
           return 'n-a';
       }

       return $text;
   }

}