<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Task controller.
 *
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * Lists all Task entities.
     *
     * @Route("/", name="task")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('AppBundle:Task')->findAll();

        return array(
            'tasks' => $tasks,
        );
    }

    /**
     * Creates a new Task entity.
     *
     * @param Request $request
     * @param string $projectIdentifier
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{projectId}/create", name="task_create")
     * @Method("POST")
     * @Template("AppBundle:Task:new.html.twig")
     */
    public function createAction(Request $request, $projectId)
    {
        //get project
        $project = $this->getProject($projectId);

        $task = new Task();
        //set project
        $task->setProject($project);
        $form = $this->createCreateForm($task);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('task_show', [
                'id' => $task->getId()
            ]));
        }

        return array(
            'entity' => $task,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Task entity.
     *
     * @param Task $task The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Task $task)
    {
        $form = $this->createForm(new TaskType(), $task, array(
            'action' => $this->generateUrl('task_create', [
                'projectId' => $task->getProject()->getId()
            ]),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Task entity.
     *
     * @param string $projectId
     *
     * @return array
     *
     * @Route("/{projectId}/new", name="task_new")
     * @Method("GET")
     * @Template()

     */
    public function newAction($projectId)
    {
        //load project
        $project = $this->getProject($projectId);

        $task = new Task();
        //set project
        $task->setProject($project);
        $form   = $this->createCreateForm($task);

        return array(
            'entity' => $task,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Task entity.
     *
     * @param string $projectIdentifier
     * @param int $id
     *
     * @return array
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
        //comment for
        $commentForm = $this->createCommentForm($task);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $task,
            'delete_form' => $deleteForm->createView(),
            'comment_form' => $commentForm->createView()
        );
    }

    /**
     * Adds a comment to a Task
     *
     * @param Request $request
     * @param int $id
     *
     * @return array
     *
     * @Route("/{id}/comment", name="task_comment")
     * @Method("PUT")
     * @Template("AppBundle:Task:show.html.twig")
     */
    public function commentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        //try to load Task from database
        $task = $em->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }
        //get form data from request
        $commentForm = $this->createCommentForm($task);
        $commentForm->handleRequest($request);
        //check if valid
        if ($commentForm->isValid()) {
            //create comment
            $comment = new Comment();
            $comment
                ->setTask($task)
                ->setText($commentForm->getData()['comment']);
            //save to database
            $em->persist($comment);
            $em->flush();
            //user notification
            $this->addFlash('success', 'Comment has been added to task.');
            //redirect
            return $this->redirectToRoute('task_show', [
                'id' => $task->getId()
            ]);
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $task,
            'delete_form' => $deleteForm->createView(),
            'comment_form' => $commentForm->createView()
        );

    }

    /**
     * @param Task $task
     * @return \Symfony\Component\Form\Form
     */
    private function createCommentForm(Task $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_comment', ['id' => $task->getId()]))
            ->setMethod('PUT')
            ->add('comment', 'textarea', [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Add your comment here',
                    'class' => 'task-comment'
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('send', 'submit', [
                'label' => 'Add Comment'
            ])
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Task entity.
     *
     * @Route("/{id}/edit", name="task_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $editForm = $this->createEditForm($task);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $task,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Task entity.
    *
    * @param Task $task The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Task $task)
    {
        $form = $this->createForm(new TaskType(), $task, array(
            'action' => $this->generateUrl('task_update', array('id' => $task->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Task entity.
     *
     * @Route("/{id}", name="task_update")
     * @Method("PUT")
     * @Template("AppBundle:Task:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($task);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('task_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $task,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Task entity.
     *
     * @Route("/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $url = $this->generateUrl('task');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $task = $em->getRepository('AppBundle:Task')->find($id);

            if (!$task) {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }

            $url = $this->generateUrl('project_show', [
                'id' >= $task->getProject()->getId()
            ]);

            $em->remove($task);
            $em->flush();
        }

        return $this->redirect($url);
    }

    /**
     * Creates a form to delete a Task entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param string $id
     * @return Project
     */
    private function getProject($id)
    {
        $em = $this->getDoctrine()->getManager();
        //load project
        $project = $em->getRepository('AppBundle:Project')->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Unable to find Project '.$id);
        }

        return $project;
    }
}
