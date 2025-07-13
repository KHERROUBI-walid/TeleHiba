<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bundle\SecurityBundle\Security;


class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

#[Route('/register', name: 'app_register')]
public function register(
    Request $request,
    UserPasswordHasherInterface $userPasswordHasher,
    EntityManagerInterface $entityManager,
    Security $security
): Response {
    $user = new User();
    $form = $this->createForm(RegistrationForm::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $plainPassword = $form->get('plainPassword')->getData();

        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $typeUtilisateur = $form->get('typeUtilisateur')->getData();
        $role = match ($typeUtilisateur) {
            'vendeur' => 'ROLE_VENDEUR',
            'donateur' => 'ROLE_DONATEUR',
            'famille' => 'ROLE_FAMILLE',
            default => 'ROLE_USER'
        };

        $user->setRoles([$role]);
        $user->setIsVerified(false);
        $entityManager->persist($user);
        $entityManager->flush();

        // Envoyer l’e-mail de confirmation
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('telehiba.donation@gmail.com', 'TeleHiba Mail'))
                ->to((string) $user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        // Connexion automatique
        $security->login($user);

        // Redirection selon le rôle
        return match ($role) {
            'ROLE_VENDEUR' => $this->redirectToRoute('app_register_vendeur'),
            'ROLE_DONATEUR' => $this->redirectToRoute('app_register_donateur'),
            'ROLE_FAMILLE' => $this->redirectToRoute('app_register_famille'),
            default => $this->redirectToRoute('app_accueil'),
        };
    }

    return $this->render('registration/register.html.twig', [
        'registrationForm' => $form,
    ]);
}


    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_accueil');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_accueil');
    }


    //     #[Route('/test-mailjet', name: 'test_mailjet')]
    // public function test(MailerInterface $mailer): Response
    // {
    //     $email = (new Email())
    //         ->from('telehiba.donation@mailjet.com')
    //         ->to('khe.walid59@gmail.com') // une adresse que tu peux vérifier
    //         ->subject('Test Mailjet')
    //         ->text('Ceci est un email de test envoyé via Mailjet avec Symfony');

    //     $mailer->send($email);

    //     return new Response('Mail envoyé via Mailjet ✅');
    // }
}
