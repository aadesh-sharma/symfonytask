namespace App\Subscribers;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ListenerEvent implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => ['preUpdate']
        ];
    }

    public function preUpdate(GenericEvent $event)
    {
        if (method_exists($event->getStatus(), 'setStatus')) {
          $event->getStatus()->setStatus('Pending');
        }
        dump($event);
    }
   /* public function postUpdate(GenericEvent $event)
    {
        if (method_exists($event->getStatus(), 'setStatus')) {
          $event->getStatus()->setStatus('Active');
        }
        dump($event);
    }
    */
}