<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 *
 * @author Fridolin Koch <info@fridokoch.de>
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getEntityManager();
        //get all tasks order by dueDate, priority
        $tasks = $manager->getRepository('AppBundle:Task')->findBy([], [
            'dueDate' => 'DESC',
            'priority' => 'DESC'
        ]);

        return $this->render('AppBundle:Dashboard:index.html.twig', [
            'tasks' => $tasks
        ]);
    }
}
