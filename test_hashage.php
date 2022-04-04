<?php

$hash = password_hash("azerty", PASSWORD_DEFAULT);

echo $hash . '<br />';

//  Vérification du mot de passe
if (password_verify('azerty', $hash)) {
    echo 'Le mot de passe est valide !';
} else {
    echo 'Le mot de passe est invalide.';
}