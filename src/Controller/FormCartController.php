<?php
namespace App\Controller;

use App\Form\PostCartType;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormCartController extends AbstractController
{
    /**
     * @Route("/form/cart", name="app_formCart")
     * @param Request $request
     * @return Response
     * @throws ApiErrorException
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(PostCartType::class, [], [
            'action' => $this->generateUrl('app_formCart'),
        ]);

        $form->handleRequest($request);

        if (!empty($_POST)) {
            if (!isset($_COOKIE['shoppingCart'])) {
                $this->addFlash('error', 'Seems like you forgot to create a stickers');
                return $this->redirectToRoute('app_homepage');
            } elseif (!isset(json_decode($_COOKIE["shoppingCart"], true)[0])) {
                $this->addFlash('error', 'Seems like your cookie is wrong');
                return $this->redirectToRoute('app_homepage');
            } else {
                $StickersPrice = 400;
                $CartPrice = 0;
                $PostCount = count($_POST);
                $StickersCount = $PostCount - 6;
                $ErrorPrice = false;
                $CartCookie = json_decode($_COOKIE["shoppingCart"], true);
                for ($i = 1; $i <= $StickersCount; $i++) {
                    $CartPrice += $StickersPrice * (int)$_POST["quantity$i"];
                    $CartCookie[$i - 1]["Quantity"] = $_POST["quantity$i"];
                    if ((int)$_POST["quantity$i"] <= 0) {
                        $ErrorPrice = true;
                    }
                }
                if ($ErrorPrice) {
                    $this->addFlash('error', 'Seems like you tried to break things, avoid that please');
                    setcookie("shoppingCart", "", time() - 3600);
                    return $this->redirectToRoute('app_homepage');
                }
                $CartJson = json_encode($CartCookie);
                setcookie("shoppingCart", $CartJson);

                require __DIR__ . '/../../vendor/autoload.php';

                Stripe::setApiKey("sk_test_51I6ceEB7U55y6nTcXNP61l3LdcUNKvAAeMH82Cx8J5gVH1Aimn0QOrFjmKqnD4eqjm5L1CfThCqZYezVum08lEIf00icPsOgtU");

                $customer = Customer::create(array(
                    "email" => $_POST['email'],
                    "name" => $_POST['name'] . ' ' . $_POST['lastName'],
                    "source" => $_POST['stripeToken'],
                    "description" => "Date de naissance : " . $_POST['bday'] . "\n Adresse de livraison : " . $_POST['address'],
                ));

                Charge::create(array(

                    "amount" => $CartPrice,
                    "currency" => "eur",
                    "customer" => $customer->id,
                    "description" => (string)($CartJson),

                ));

                $this->addFlash('success', 'Your Payment has been successfully proceed');
                return $this->redirectToRoute('app_formPDF');
            }

        }
        return $this->render('form_cart/index.html.twig', [
            "controller_name" => "FormCartController",
            "post_cart" => $form->createView()
        ]);
    }
}