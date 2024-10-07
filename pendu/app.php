<?php
/*
    Fonction principale du jeu du pendu...

    N'hésitez pas à utiliser d'autres fichiers avec les outils d'importation appropriés.

    Il se peut que vous ayez besoin d'utiliser des fonctions prédéfinies que nous n'avons pas vues.

    Voici quelques fonctions dont vous pourriez avoir besoin : 
        array_rand() : permet de sélectionner une clé de tableau aléatoirement.
        array_search() : permet de vérifier si une valeur existe dans un tableau.
        isset() : permet de vérifier si un élément existe.
        strlen() : permet de connaître le nombre de caractères présent dans une chaîne.
        strpos() : permet de savoir si un caractère est présent dans une chaîne.
        ctype_lower() : permet de vérifie qu'une chaîne est en minuscules.
        str_repeat() : permet de répéter un nombre défini de fois un même caractère.
        range() : permet de génèrer une séquence de nombres ou de caractères sous forme de tableau.

    https://www.php.net/manual/fr/
*/

function random_word(string $categorie): string
{
    $fichier = file_get_contents(__DIR__ . "/../data/dictionnaire.json");

    // On décode le dictionnaire
    $dictionnaire = json_decode($fichier, true);
    
    //Vérification du décodage (si réussi)
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erreur lors du décodage du JSON');
    }

    // $categories = [
    //     1 => 'nourriture',
    //     2 => 'animaux',
    //     3 => 'profession',
    //     4 => 'sciences',
    // ];

    // $choix = readline('Choisis une catégorie: [1] nourriture [2] animaux [3] profession [4] sciences [5] aléatoire : ');
    
    // if (5 == $choix) {
    //     $categorie = array_rand($dictionnaire);
    // } else {
    //     if (!isset($categories[$choix])) {
    //         echo "Choix invalide, veuillez choisir un numéro valide.";
    //         return ""; 
    //     }
    //     $categorie = $categories[$choix];
    // }
    
    if ($categorie === 'aléatoire') {
        $categorie = array_rand($dictionnaire);
    }
    if (!isset($dictionnaire[$categorie])) {
        throw new Exception("La catégorie '$categorie' n'existe pas dans le dictionnaire.");
    }

    $mots = $dictionnaire[$categorie];
    $motaleatoire = $mots[array_rand($mots)];

    return $motaleatoire;
}

function ask_letter(&$lettresProposees)
{
    $proposition = strtolower(readline("Proposez une lettre : "));
    $lettresProposees[] = $proposition;

    return $proposition;
}

function mettre_a_jour_mot_cache($mot_a_trouver, $mot_cache, $lettre)
{
    $majmot = '';
    for ($i = 0; $i < strlen($mot_a_trouver); $i++) {
        if ($mot_a_trouver[$i] === $lettre) {
            $majmot .= $lettre;
        }elseif ($mot_cache[$i] !== '_') {
            $majmot .= $mot_cache[$i];
        }else {
            $majmot .= '_';
        }
    }
    return $majmot;
}

function viejoueur()
{
    $vies = 5;
    echo "Il vous reste " . $vies . " vies.";

    if ($vies === 0) {
        echo "Vous avez perdu, looser";
    }
}

function check_letter($lettre, $mot_a_trouver): bool
{
    return strpos($mot_a_trouver, $lettre) !== false;
}

function afficher_etat_jeu($motCache, $lettresProposees, $vies)
{
    echo "Mot à trouver : $motCache\n";
    echo "Lettres proposées : " . implode(', ', $lettresProposees) . "\n";
    echo "Vies restantes : $vies\n";

}

function afficher_resultat($mot_a_trouver, $vies)
{
    if ($vies === 0) {
        echo "Vous avez perdu ! Le mot était : $mot_a_trouver \n";
    } else {
        echo "Félicitation, vous avez réussi a trouver le mot $mot_a_trouver \n";
    }
}
