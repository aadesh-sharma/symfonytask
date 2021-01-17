<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
class MyController extends AbstractController
{   
    /**
     * @Route("/my", name="my")
     */
    public function index(LoggerInterface $logger)
    {
     $logger->info('logger info ');
     $logger->error('logger error');

     $logger->critical('logger critical', [
        // include extra "context" info in your logs
        'cause' => 'in_hurry',
     ]);

     return $this->render('my/index.html.twig', [
                 'controller_name' => 'MyController',
             ]);

    // ...

    // /**
    //  * @Route("/my", name="my")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('my/index.html.twig', [
    //         'controller_name' => 'MyController',
    //     ]);
    // }
    }
    
    /**
     * @Route("/my/show", name="my_show")
     */
    public function show(){
        $cache = new FilesystemAdapter();

        $value = $cache->get('mmy_key', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            echo"12";
            // ... do some HTTP request or heavy computations
            $computedValue = 'foobar';
        
            return ($computedValue);
            
        });
        
        dump($value); // 'foobar'
        return $this->render('my/index.html.twig', [
            'controller_name' => 'MyController',
        ]);
      // ... and to remove the cache key
       //$cache->delete('my_cache_key');

    }
}
