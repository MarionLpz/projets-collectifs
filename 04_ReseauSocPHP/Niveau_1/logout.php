<?php

//Démarrer la session
session_start();

// Détruire toutes les données de la session
session_destroy();

// Rediriger vers la page de connexion ou toute autre page souhaitée
header("Location: login.php");
exit();
