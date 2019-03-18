<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 18.03.19
 * Time: 21:21
 */

namespace App\Command;

use App\Entity\ToDoList;
use App\FireBaseBundle\Entity\Device;
use App\FireBaseBundle\Service\FireBaseService;
use App\Service\SendNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendNotificationCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send:notification';

    private $fireBase;
    private $em;

    public function __construct(EntityManagerInterface $em, FireBaseService $fireBase, ?string $name = null)
    {
        $this->em = $em;
        $this->fireBase = $fireBase;
        parent::__construct($name);
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $date = new \DateTime();

            $toDoList = $this->em->createQueryBuilder()
                ->select('x')
                ->from(ToDoList::class, 'x')
                ->andWhere('x.dueDate BETWEEN :sDate AND :eDate')
                ->setParameter('sDate', $date->format("Y-m-d H:i") . ':00')
                ->setParameter('eDate', $date->format("Y-m-d H:i:s") . ':59')
                ->getQuery()->execute();
            /** @var ToDoList $ToDoItem */
            foreach ($toDoList as $ToDoItem) {
                $this->send($ToDoItem->user,$ToDoItem);
            }

            $output->write("ok\n");
        } catch (\Exception $e) {
            dump($e);
            $output->write("error\n");
        }
    }

    private function send($user,ToDoList $data)
    {
        $devices = $this->em->getRepository(Device::class)->findBy(['user' => $user]);

        $messageNotification = [
            'title' => $data->title,
            'body' => $data->description
        ];
        $messageData = [
            'id' => $data->getId(),
            'action' => 'notification'
        ];
        /** @var Device $device */
        foreach ($devices as $device) {
            $this->fireBase->sendNotification($device->deviceId, $messageNotification, $messageData);
        }

    }
}