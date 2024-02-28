<?php

namespace App\Controller;

use App\Form\PostContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use const PHP_EOL;

class FormContactController extends AbstractController
{
    /**
     * @Route("/form/contact", name="app_formContact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(PostContactType::class, [], [
            'action' => $this->generateUrl('app_formContact'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from('comptedetest.02123@gmail.com')
                ->to($_POST['email'])
                ->subject('Mail from the Projet_e-commerce website')
                ->text('Sender : ' . $_POST['email'] . PHP_EOL .
                    $_POST['message'],
                    'text/plain');
            $mailer->send($message);

            $this->addFlash('success', 'Your message has been sent');
            return $this->redirectToRoute('app_formContact');
        }

        return $this->render('form_contact/index.html.twig', [
            "controller_name" => "FormContactController",
            "post_form_contact" => $form->createView()
        ]);
    }
}
