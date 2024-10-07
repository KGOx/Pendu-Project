<?php
// Appliquer la déclaration stricte des types.
declare(strict_types=1);

include 'pendu/app.php';

function choisir_categorie(): string
{
    $categories = [
        1 => 'nourriture',
        2 => 'animaux',
        3 => 'profession',
        4 => 'sciences',
        5 => 'aléatoire'
    ];
    
    $choix = readline('Choisis une catégorie: [1] nourriture [2] animaux [3] profession [4] sciences [5] aléatoire : ');
    
    if (isset($categories[$choix])) {
        return $categories[$choix];
    } else {
        echo "Choix invalide, veuillez choisir un numéro valide.\n";
        return choisir_categorie(); // Re-demande une catégorie si le choix est invalide
    }
}
$categorie = choisir_categorie();

function play($categorie)
{
    $mot_a_trouver = random_word($categorie);
    $mot_cache = str_repeat("_", strlen($mot_a_trouver));
    $vies = 5;
    $lettres_proposees = [];
    
    while ($vies > 0 && $mot_cache !== $mot_a_trouver) {
        afficher_etat_jeu($mot_cache, $lettres_proposees, $vies);

        $lettre = ask_letter($lettres_proposees);
        
        if (check_letter($lettre, $mot_a_trouver)) {
            $mot_cache = mettre_a_jour_mot_cache($mot_a_trouver, $mot_cache, $lettre);
        }
        else {
            $vies--;
        }
    }
    afficher_resultat($mot_a_trouver, $vies);
}
/*
    Importez le(s) fichier(s) nécessaire(s).
    Lancez la partie en appelant la fonction principale que vous aurez développé dans le fichier 'pendu/app.php'.
*/
play($categorie);