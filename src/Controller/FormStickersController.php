<?php

namespace App\Controller;

use App\Form\PostStickersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormStickersController extends AbstractController
{
    /**
     * @Route("/form/stickers", name="app_formStickers")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {


        //        function uploadStickers($name)
        //         {
        //            if (!file_exists("StickersLogo/$name.json")) {
        //               touch("StickersLogo/$name.json");
        //            }
        //              $myFile = fopen("StickersLogo/{$name}.json", "w") or die("Unable to open file!");
        //            $fullName = str_replace(" ", "", "{$_POST['stickersName']}");
        //             $fullName = $fullName . " " . str_replace(" ", "", "{$_POST['stickersLastName']}");
        //            $txt = array(
        //                "1" => "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",
        //                "2" => "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",
        //              "3" => "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"
        //            );
        //          fwrite($myFile, json_encode($txt));
        //           fclose($myFile);
        //      }

        $form = $this->createForm(PostStickersType::class, [], [
            'action' => $this->generateUrl('app_formStickers'),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if (!isset($_COOKIE['shoppingCart'])) {
                $FullName = (string)$_POST['stickersName'] . ' ' . (string)$_POST['stickersLastName'];
                $TextColor = (string)$_POST['textColor'];
                $BackColor = (string)$_POST['backColor'];
                $LogoChoice = (string)$_POST['logoChoice'];
                $w = array(array("FullName" => "$FullName", "TextColor" => "$TextColor", "BackColor" => "$BackColor", "LogoChoice" => "$LogoChoice", "Quantity" => "1"),);
                $t = json_encode($w);
                setcookie("shoppingCart", $t);
            } else {
                $CartCookie = json_decode($_COOKIE['shoppingCart'], true);
                $FullName = (string)$_POST['stickersName'] . ' ' . (string)$_POST['stickersLastName'];
                $TextColor = (string)$_POST['textColor'];
                $BackColor = (string)$_POST['backColor'];
                $LogoChoice = (string)$_POST['logoChoice'];
                array_push($CartCookie, array("FullName" => "$FullName", "TextColor" => "$TextColor", "BackColor" => "$BackColor", "LogoChoice" => "$LogoChoice", "Quantity" => "1"));
                $CartJson = json_encode($CartCookie);
                setcookie("shoppingCart", $CartJson);
            }
            //    uploadStickers("newStickers");
            return $this->redirect('/form/cart');
        }

        return $this->render('form_stickers/index.html.twig', [
            "controller_name" => "FormStickersController",
            "post_form_stickers" => $form->createView()
        ]);
    }
}