<?php

namespace App\Controller\Admin;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CategoryCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        //if ('jane' === $this->getUser()->getUsername()) {
         //   return $this->redirect('...');
        //}

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //return $this->render('some/path/my-dashboard.html.twig');


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Catpost');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        
        yield MenuItem::linkToCrud('Category', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Comment', 'fas fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Post', 'fa fa-file-text', Post::class);
        //->setSubItems([
          //  MenuItem::linkToCrud('Category', 'fa fa-tags', Category::class)]);

        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);


        
    }
}
