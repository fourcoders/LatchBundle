<?php

namespace Fourcoders\Bundle\LatchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fourcoders\Bundle\LatchBundle\Form\Type\LatchType;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $form = $this->createForm(new LatchType(), null);
        if ($request->getMethod() == 'POST') {
            (method_exists($form, 'getRequest'))
                ? $form->bindRequest($request)
                : $form->handleRequest($request);
            if ($form->isValid()) {
                $response = $this->getPairResponse($request);
                if (null !== $response->getData()) {
                    $latchUserManager = $this->container->get('latch_user_manager');
                    $latchUserManager->pairLatch($response->getData()->accountId);
                    $redirect = $this->container->getParameter('latch_redirect');

                    return $this->redirect(empty($redirect) ? '/' : $redirect);
                } else {
                    $error = $response->getError();
                }
            } else {
                $error = array('message' => 'Empty code');
            }
        }

        return $this->render('FourcodersLatchBundle:Registration:register.html.twig', array(
            'error' => isset($error) ? $error : array('message' => '' ),
            'form' => $form->createView(),
        ));
    }

    protected function getPairResponse(Request $request)
    {
        $manager = $this->container->get('latch_factory')->getManager();
        $pairResponse = $manager->pair($request->request->get('latch'));

        return $pairResponse;
    }
}
