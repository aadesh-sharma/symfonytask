<?php
namespace App\EventSubscriber;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Category;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Twig\Mime\NotificationEmail;


class EasyAdminSubscriber implements EventSubscriberInterface
{    
     /**
     * @var Security
     */
    private $security;

    private $mailer;
    private $adminEmail;
    private $UserRepository;

    public function __construct(Security $security,MailerInterface $mailer, string $adminEmail,UserRepository $UserRepository)
    {
        $this->security = $security;
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
        $this->UserRepository= $UserRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setCommentBy'],
            AfterEntityPersistedEvent::class=>['sendMail'],
            AfterEntityUpdatedEvent::class=>['sendPostCommMail'],
            //AfterCrudActionEvent::class=>['sendMail'],
            //BeforeEntityPersistedEvent::class => ['setUserStatus'],
            //AftereEntityPersistedEvent::class => ['setUserStatus'],
            //AfterEntityDeletedEvent::class => ['setUserStatus'],
        ];
    }

    public function setCommentBy(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Comment){
         $entity->setCommentBy($this->security->getUser());
        //dump($this->security->getUser());
        }
        else{
            return ;
        }

      
    }


    public function sendMail(AfterEntityPersistedEvent $event)
    {   dump("created");
        $entity = $event->getEntityInstance();
       $entity = $event->getEntityInstance();
    //     dump($entity);
    //     if (!($entity instanceof User)) {
    //         return;
    //     }
            
    //     //$status ="active";    
    //     //$cmby=$entity->get
    //     //$entity->setStatus($status);

    //     $entity->setStatus("pending");
    //     $entity->setStatus("active");
    //     $entity->setStatus("trashed");
    

       
    }
    


    // public function setUserStatus(BeforeEntityPersistedEvent $event)
    // {
    //     $entity = $event->getEntityInstance();
    //     dump($entity);
    //     if (!($entity instanceof User)) {
    //         return;
    //     }
            
    //     //$status ="active";    
    //     //$cmby=$entity->get
    //     //$entity->setStatus($status);

    //     $entity->setStatus("pending");
    //     $entity->setStatus("active");
    //     $entity->setStatus("trashed");
        
    // }

}
