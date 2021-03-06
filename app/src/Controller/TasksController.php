<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Entity\User;
use App\Form\TaskFormType;
use App\Repository\TasksRepository;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TasksController extends AbstractController
{   
    /**
     * @var Security
     */
    private $security;
    private $em;

    public function __construct(EntityManagerInterface $em, TasksRepository $taskRepository, Security $security)
    {
        $this->security = $security;
        $this->em = $em;
        $this->taskRepository = $taskRepository;
    }

    #[Route('/tasks', name: 'app_tasks')]
    public function index(): Response
    {

        $securityUser = $this->security->getUser();
        if(!$securityUser) {
            return $this->redirectToRoute('app_login');
        }
        $id = $securityUser->getId();
        
        $tasks = $this->taskRepository->findBy(['user_id'=>$id]);
        
        // dd($tasks);

        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/tasks/create', name: 'app_create_task')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {   
        $securityUser = $this->security->getUser();
        $task = new Tasks();
        $form = $this->createForm(TaskFormType::class, $task);
        
        $form->handleRequest($request);

        
        if(!$securityUser) {
            return $this->redirectToRoute('app_login');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            
            $newTask = $form->getData();
            $newTask->setUserId($securityUser);

            $em->persist($newTask);
            $em->flush();

            // dd($newTask);
            // dd($securityUser);
            // exit;
            return $this->redirectToRoute('app_tasks');
        }


        return $this->render('tasks/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/tasks/delete/{id}', name: 'app_delete_task')]
    public function delete($id,Request $request): Response
    {
        $task = $this->taskRepository->find($id);
        $this->em->remove($task);
        $this->em->flush();

        return $this->redirectToRoute('app_tasks');
        // dd($task);
    }

    #[Route('/tasks/edit/{id}', name: 'app_edit_task')]
    public function edit($id,Request $request): Response
    {
        $task = $this->taskRepository->find($id);
        // $this->checkLoggedInUser($id);
        // dd($task);
        $securityUser = $this->security->getUser();

        if(!$securityUser) {
            return $this->redirectToRoute('app_login');
        }

        
        $form = $this->createForm(TaskFormType::class, $task);
        
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){
            
            $formData = $form->getData();
            $this->em->flush();
            // dd($formData);
            return $this->redirectToRoute('app_tasks');
        }
        return $this->render('tasks/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView()
        ]);
    }
}