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
     
     //send mail after user created   
        if ($entity instanceof User){
          $this->mailer->send((new NotificationEmail())
          ->subject('New user created')
          ->htmlTemplate('emails/user_notification.html.twig')
          ->from($this->adminEmail)
          ->to($this->adminEmail)
          ->context(['comment' => "user created"])
          );
            
        }

        //send mail to all authors when new category created   
        if ($entity instanceof Category){
            $cat_name=$entity->getName();
            $all_auhtors=$this->$UserRepository->findBy([
                'roles' => 'ROLE_AUTHOR'
            ]);
            
            $this->mailer->send((new NotificationEmail())
            ->subject('New Category created')
            ->htmlTemplate('emails/user_notification.html.twig')
            ->from($this->adminEmail)
            ->to($all_authors)
            //->to($this->adminEmail)
            ->context(['comment' => $cat_name])
            );
              
          }

    }
    
    public function sendPostCommMail(AfterEntityUpdatedEvent $event)
    {   
        $entity = $event->getEntityInstance();
     
     //send mail after post status changed    
        if ($entity instanceof Post){
          $this->mailer->send((new NotificationEmail())
          ->subject('Post status changed')
          ->htmlTemplate('emails/user_notification.html.twig')
          ->from($this->adminEmail)
          ->to($this->adminEmail)
          ->context(['comment' => "post status changed"])
          );
            
        }

         //send mail after  comment status changed    
         if ($entity instanceof Comment){
            $this->mailer->send((new NotificationEmail())
            ->subject('Comment status changed')
            ->htmlTemplate('emails/user_notification.html.twig')
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->context(['comment' =>"comment status changed"])
            );
              
          }
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
