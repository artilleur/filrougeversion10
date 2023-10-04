<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        return $this->render('panier/index.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/add/{id}', name: 'app_panier_add')]
    public function add(Produit $produit, SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        $panier[] = $produit;

        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }

    #[Route('/remove/{id}', name: 'app_panier_remove')]
    public function remove(Produit $produit, SessionInterface $session): Response
    {
        $panier = $session->get("panier", []);

        // Recherchez l'index du produit dans le panier
        $index = array_search($produit, $panier);

        // Si le produit est trouvé, supprimez-le du panier
        if ($index !== false) {
            unset($panier[$index]);
        }

        // Enregistrez le panier mis à jour dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_panier");
    }

    #[Route('/clear', name: 'app_panier_clear')]
    public function clear(SessionInterface $session): Response
    {
        $session->set("panier", []);

        return $this->redirectToRoute("app_panier");
    }

    
}