<?php

namespace App\Controller;

use App\Form\PasswordResetType;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordController extends AbstractController
{

    /**
     * @var UserRepository
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var string
     * @var boolean
     * @var DateTime
     * @var UserPasswordEncoderInterface
     */
    private $userRepository;
    private $emailUsername;
    private $emailPassword;
    private $emailHost;
    private $error;
    private $success;
    private $lastUsername;
    private $token;
    private $tokenError;
    private $currentTime;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, string $emailHost, string $emailUsername, string $emailPassword, UserPasswordEncoderInterface $passwordEncoder)
   {
       $this->userRepository = $userRepository;
       $this->emailUsername = $emailUsername;
       $this->emailPassword = $emailPassword;
       $this->emailHost = $emailHost;
       $this->error = "";
       $this->success = "";
       $this->lastUsername = "";
       $this->token = "";
       $this->tokenError = false;
       $this->currentTime = new DateTime();
       $this->passwordEncoder = $passwordEncoder;
   }

    /**
     * @Route("/forgot-password", name="app_forgot_password")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws Exception
     */
    public function forgotPassword(Request $request, EntityManagerInterface $entityManager)
    {

        $startEmailTime = date("d-m-Y H:i:s");
        $emailExpiresDate = date('d-m-Y H:i',strtotime('+1 hour',strtotime($startEmailTime)));

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            if (empty($email)) {
                $this->error = "Please enter your email.";
            }

            $user = $this->userRepository->findOneBy(['email' => $email]);
            $firstName = $user->getFirstName();
            if ($user === null) {
                $this->error = "Sorry! No email address found!";
                $this->lastUsername = $email;
            } else {
                try {
                    $this->token = Uuid::uuid1();
                } catch (UnsatisfiedDependencyException $e) {
                    echo 'Caught exception: ' . $e->getMessage() . "\n";
                }

                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = $this->emailHost;                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = $this->emailUsername;                     // SMTP username
                    $mail->Password   = $this->emailPassword;                            // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('pwsteven13@gmail.com', 'Paul Steven');
                    $mail->addAddress('psteven13@outlook.com', $firstName);     // Add a recipient
                    //$mail->addAddress('ellen@example.com');               // Name is optional
                    $mail->addReplyTo('pwsteven13@gmail.com', 'Paul Steven');
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com');

                    // Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Password Recovery Link';
                    $mail->Body    = $this->render('email/forgot_password.html.twig', [
                        'first_name' => $firstName,
                        'token' => $this->token->toString(),
                        'expires_date' => $emailExpiresDate,
                    ]);

                    $alt_message = 'Hi '.$firstName.', \n\n';
                    $alt_message .= 'We\'ve received a request to reset the password for your British Airways OnBoarding account. Click this link to reset your password: https://127.0.0.1:8000/reset-password/'.$this->token->toString().' \n\n';
                    $alt_message .= 'This link will automatically expire after '.$emailExpiresDate.' \n\n';
                    $alt_message .= 'If you did not request to change your password then please disregard this message. \n\n';
                    $alt_message .= 'This is an automated message sent from our application, please do not reply to this email. If you require further assistance then please contact our team by calling us free on 0800 634 7575. \n\n';
                    $alt_message .= 'Thanks, \n';
                    $alt_message .= 'Your Lawyers Customer Support \n\n';
                    $alt_message .= 'This email was submitted from ba.yourlawyers.co.uk';
                    $mail->AltBody = $alt_message;

                    $mail->send();
                    $this->success = 'Password recovery email sent.';

                    //UPDATE DATABASE
                    $user->setToken($this->token->toString());
                    $user->setExpiresAt(new DateTime('+1 hour'));
                    $entityManager->persist($user);
                    $entityManager->flush();

                } catch (Exception $e) {
                    $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            }

        }

        return $this->render('security/forgot_password.html.twig', [
            'error' => $this->error,
            'success' => $this->success,
            'last_username' => $this->lastUsername,
        ]);
    }

    /**
     * @Route("/reset-password")
     */
    public function index()
    {
        return $this->redirectToRoute('app_forgot_password');
    }

    /**
     * @Route("/reset-password/{id}", name="app_reset_password")
     * @param string $id
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function resetPassword(string $id, Request $request, EntityManagerInterface $entityManager)
    {

        // CHECK TO SEE WE HAVE AN ID VARIABLE
        $user = $this->userRepository->findOneBy(['token' => $id]);
        if (!$user) {
            $this->tokenError = true;
        }
        if ($this->currentTime > $user->getExpiresAt()) {
            $this->tokenError = true;
        }

        $form = $this->createForm(PasswordResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $this->lastUsername = $form['password']->getData();
            $user->setPassword($this->passwordEncoder->encodePassword(
               $user,$this->lastUsername
            ));
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Password has been reset. Please login.');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/reset_password.html.twig', [
            'token_error' => $this->tokenError,
            'form' => $form->createView(),
        ]);
    }
}
