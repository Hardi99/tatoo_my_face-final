<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Salon;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppointmentController extends AbstractController
{
    /**
     * @Route("/appointment", name="app_appointment")
     */
    public function index(): Response
    {
        return $this->render('appointment/index.html.twig', [
            'controller_name' => 'AppointmentController',
        ]);
    }
    
    public function new(Request $request, int $id, Salon $salon, AppointmentRepository $appointmentRepository, MailerInterface $mailer)
    {
        $appointments = $this->getEvents($id);

        $salonId= $this->getDoctrine()->getRepository(Salon::class)->find($id);
        if (!$salonId) {
            throw $this->createNotFoundException('Le salon n\'existe pas');
        }

        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment, [
            'salon_id' => $id,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = Uuid::uuid4()->toString();
            $appointment->setToken($token);
            $appointment->setSalon($salon);

            $em = $this->getDoctrine()->getManager();
            $em->persist($appointment);
            $em->flush();
            
            // Récupérez les données du formulaire
            $name = $appointment->getFirstname();
            $name2 = $appointment->getLastname();
            $email = $appointment->getEmail();
            $salon = $appointment->getSalon();
            $salonName = $salon->getName();
            $token = $appointment->getToken();
        
            // Créez l'objet Email
            $email = (new Email())
                ->from('contact@exemple.com')
                ->to($email)
                ->subject('Rendez-vous chez '.$salonName.' ')
                ->text('Cher '.$name.' '.$name2.', Nous confirmons votre prise de rendez-vous chez '.$salonName.'. Si vous souhaitez annuler votre rendez-vous, cliquez sur ce lien : http://127.0.0.1:8000/appointments/view/'.$token.'')
                ->html('<h1>Cher '.$name.' '.$name2.',</h1><br> <p>Nous confirmons votre prise de rendez-vous chez '.$salonName.'. Si vous souhaitez annuler votre rendez-vous, cliquez sur ce lien :</p> <a href="http://127.0.0.1:8000/appointments/view/'.$token.'">Annuler rendez-vous</a>');

            // Envoyez l'e-mail
            $mailer->send($email);
            return $this->redirectToRoute('appointment.success', ['id' => $id]);
        }

        $styles = $salon->getTatooStyle();

        return $this->render('appointment/new.html.twig', [
            'form' => $form->createView(),
            'salon' => $salon,
            'styles' => $styles,
            'appointments' => $appointments
        ]);
    }
    
    public function success(int $id, Salon $salon)
    {
        return $this->render('appointment/success.html.twig',[
            'salon' => $salon,
            'salon_id' => $id,
        ]);
    }

    /**
     * @Route("/appointments/view/{token}", name="appointment.view")
     */
    public function view(string $token)
    {
        $appointment = $this->getDoctrine()->getRepository(Appointment::class)->findOneBy(['token' => $token]);

        if (!$appointment) {
            throw $this->createNotFoundException('Le rendez-vous n\'a pas été trouvé.');
        }

        return $this->render('appointment/view.html.twig', [
            'appointment' => $appointment,
            'token' => $token,
        ]);
    }

    /**
     * @Route("/appointment/delete/{token}", name="appointment.delete")
     */
    public function delete(string $token)
    {
        $appointment = $this->getDoctrine()->getRepository(Appointment::class)->findOneBy(['token' => $token]);
        if (!$appointment) {
            throw $this->createNotFoundException('Le rendez-vous n\'a pas été trouvé.');
        }
        // Delete the appointment
        $em = $this->getDoctrine()->getManager();
        $em->remove($appointment);
        $em->flush();
        // Redirect to confirmation page
        return $this->redirectToRoute('appointment.cancel');
    }
    
    /**
     * @Route("/appointment/cancel", name="appointment.cancel")
     */
    public function cancel()
    {
        return $this->render('appointment/cancel.html.twig');
    }
    
    public function getEvents($id)
    {
        // Get the appointments for the given salon id
        $appointments = $this->getDoctrine()->getRepository(Appointment::class)->findBy(['salon' => $id]);

        // Format the appointments as events for FullCalendar
        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->getLastName(),
                'start' => $appointment->getAppointmentAt()->format('Y-m-d').'T'.$appointment->getStart()->format('H:i:s'),
                'end' => $appointment->getAppointmentAt()->format('Y-m-d').'T'.$appointment->getEnd()->format('H:i:s'),
                ];
            }
                return new JsonResponse($events);
    }
}

