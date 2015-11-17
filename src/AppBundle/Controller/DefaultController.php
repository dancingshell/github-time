<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commit;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/commit_endpoint", name="endpoint")
     */
    public function commitEndpoint(Request $request)
    {
        if ($request->getContent()) {
            $commit = new Commit();
            $content = json_decode($request->getContent(), true);
            $commit->setData(json_encode($content['repository']['full_name']));

            $doctrine = $this->getDoctrine()->getEntityManager();
            $doctrine->persist($commit);
            $doctrine->flush();
        }

        return new JsonResponse($request);
    }
}
