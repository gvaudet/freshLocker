<?php 

namespace App\Classes;

use App\Entity\Category;
// Doctrine avec les ORM au dessus des entités vraiment nécessaire? Essaie de refaire une classe Symfony avec les "bonnes pratiques"
use Doctrine\ORM\Mapping as ORM;

// Les propriétés sont en public pour alléger le code et non nécessaire pour le moment sinon obligé de déclarer des Setters and Getters
class Search 
{
    #[ORM\Column]
    public ?string $string; 

    // A vérifier car sur le net la variable $categories est enregistrer de base en tableau vide => $categories = []; 
    // Seulement VsCode ne veut pas utiliser le tableau vide à la déclaration. 
    #[ORM\Column]
    public array $categories =[];

}

