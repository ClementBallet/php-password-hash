<?php
echo "<h1>Comment crypter et décrypter un mot de passe ?</h1>";

// Voici un mot de passe. Admettons qu'il a été récupéré d'un formulaire d'inscription utilisateur.
$password = "azerty1234";

var_dump($password);

// Utilisation de password_hash() basique
// PASSWORD_DEFAULT utilise l'algorithme le plus récent et le plus fort ajouté récemment à PHP
// https://www.php.net/manual/fr/function.password-hash.php
$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

// Le password est maintenant crypté et on peut l'envoyer en base de données. C'est cette donnée qui va être enregistrée et jamais une chaine de caractère en clair.

var_dump($encryptedPassword);

// On peut éventuellement préciser un mode de hashage différent
$encryptedPasswordBcrypt = password_hash($password, PASSWORD_BCRYPT);
$encryptedPasswordArgon2i = password_hash($password, PASSWORD_ARGON2I);
$encryptedPasswordArgon2id = password_hash($password, PASSWORD_ARGON2ID);

var_dump($encryptedPasswordBcrypt, $encryptedPasswordArgon2i, $encryptedPasswordArgon2id);

// On peut déterminer un coût (cost), c'est le coût algorithmique qui doit être utilisé. Il est de 10 par défaut.
$encryptedPasswordWithCost = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
var_dump($encryptedPasswordWithCost);

// On peut vérifier le password password_verify() en passant en premier paramètre la chaine de caractère que l'on veut tester (admettons que l'on reçoive cette chaine d'un formulaire de connexion), et en second paramètre le mot de passe encrypté avec password_hash().
// Si il y a concordance alors password_verify() renvoie true.
if ( password_verify($password, $encryptedPassword) )
{
    echo "$password : password valide.<br>";
}
else
{
    echo "$password : password invalide.<br>";
}

$wrongPassword = "qwerty1234";

// Si on refait la même opération avec le mauvais password alors password_verify() renverra false.
if ( password_verify($wrongPassword, $encryptedPassword) )
{
    echo "$wrongPassword : password valide.<br>";
}
else
{
    echo "$wrongPassword : password invalide.<br>";
}

// On peut retrouver des infos sur une chaine hashée avec password_get_info()
// https://www.php.net/manual/fr/function.password-get-info.php
var_dump(password_get_info($encryptedPasswordArgon2i));

// On peut refaire un hash sur une chaine déjà hashée avec password_needs_rehash() en passant en paramètre de nouvelles options
// Cette fonction retourne true si le hachage doit être re-généré pour correspondre aux paramètres algo et options fournis, ou false sinon.
// https://www.php.net/manual/fr/function.password-needs-rehash.php
password_needs_rehash($encryptedPasswordArgon2i, PASSWORD_DEFAULT, ['cost' => 12]);
