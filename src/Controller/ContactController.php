<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
    /**
     * @Route("/contactanos", name="contact")
     */
    public function index()
    {
        return $this->render('frontend/contact/index.html.twig', [
            'title' => 'Contacto',
        ]);
    }

    /**
             * @Route("/request/sendcontactmail", name="request-sendcontactmail")
             */
             public function sendContactMail(Request $request, \Swift_Mailer $mailer){

               if($mailto = $request->request->get('mail')){
                         $phoneto = $request->request->get('phone');
                         $nameto = $request->request->get('name');
                         $messageto = $request->request->get('message');

                         $message = (new \Swift_Message('Hello Email'))
                         ->setSubject('Contacto - BYJ Construmetal')
                         ->setFrom('joscri2698@gmail.com','BYJ Construmetal')
                         ->setTo('josepuma@sayrin.cl')
                         ->setBody(
                           $this->renderView(
                             'emails/contact.html.twig',
                              array(
                                'name' => $nameto,
                                'phone' => $phoneto,
                                'message' => $messageto,
                                'mail' => $mailto
                            )
                           ),
                           'text/html'
                         );

                         $mailer->send($message);
                         return new JsonResponse(array(
                                    'mail' => $mailto
                                  ));

               }

             }

}
