<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TaskFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(): Response
    {
        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }

    #[Route('/tasks/create', name: 'app_create_task')]
    public function create(): Response
    {   
        $task = new Tasks();
        $form = $this->createForm(TaskFormType::class, $task);

        // return $this->render('tasks/create.html.twig', [
        //     'controller_name' => 'TasksController',
        // ]);
        return $this->createForm('tasks/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
