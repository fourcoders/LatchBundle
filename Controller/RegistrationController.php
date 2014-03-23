<?php

namespace Fourcoders\Bundle\LatchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Fourcoders\Bundle\LatchBundle\Latch\Latch;
use Fourcoders\Bundle\LatchBundle\Latch\LatchResponse;
use Fourcoders\Bundle\LatchBundle\Latch\Error;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	if ($request->getMethod() == 'POST') {
    		if ($_POST['latch'] != '') {
			    $appId = $this->container->getParameter('latch_app_id');
			    $appSecret = $this->container->getParameter('latch_app_secret');
			    $api = new Latch($appId, $appSecret);
			    //$api->setProxy(YOUR_PROXY);
			    $pairResponse = $api->pair($_POST['latch']);
                $response = $pairResponse->getData();
                if (isset($response)) {
                    $user->setLatch($response->accountId);
				    $em = $this->getDoctrine()->getManager();
				    $em->persist($user);
				    $em->flush();
				    $redirect = $this->container->getParameter('latch_redirect');
				    return $this->redirect( empty($redirect) ? '/' : $redirect );
                } else {
                	$error = $pairResponse->getError();
                }
    		} else {
    			$error = array('message' => 'Empty code');
    		}
    	}
        return $this->render('FourcodersLatchBundle:Registration:register.html.twig', array(
        	'error' => isset($error) ? $error : array('message' => '' )
        ));
    }
}
