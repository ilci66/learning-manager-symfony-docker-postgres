<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TaskFormType;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TasksController extends AbstractController
{   
    private $em;

    public function __construct(EntityManagerInterface $em, TasksRepository $taskRepository)
    {
        $this->em = $em;
        $this->taskRepository = $taskRepository;
    }

    #[Route('/tasks', name: 'app_tasks')]
    public function index(): Response
    {
        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }

    #[Route('/tasks/create', name: 'app_create_task')]
    public function create(Request $request): Response
    {   
        $task = new Tasks();
        $form = $this->createForm(TaskFormType::class, $task);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newTask = $form->getData();
            dd($newTask);
            exit;
        }


        return $this->render('tasks/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
