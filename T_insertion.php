<?php
//ceci est la page envoi
// Partie 1 : Récupération des données
// Partie 2 : Connexion à la BD en PDO
// Partie 3 : Insertion des données
//Partie 1 *************************************************
$recup_nom=$_POST['Nom'];
$recup_email=$_POST['Email'];
$recup_sujet=$_POST['Sujet'];
$recup_message=$_POST['Message'];
$secretKey="6LdvAI0UAAAAAKkcX97j_d2nF3CzXspxwz2Phy1U";
$responseKey=$_POST['g-recaptcha-response'];
$useIP=$_SERVER['REMOTE_ADDR'];
$url="https://recaptcha.net/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$useIP";
$response=file_get_contents($url);
$response=json_decode($response);
$currentTime = date('Y-m-d H:i:s',time());
//Partie 2 **************************************************
include('connect.php');
//Partie 3 ************************************************
if($response->success){
  $req = $bdd->prepare("INSERT INTO client (Nom,Email,Sujet,Message,date)
  VALUES (:Nom, :Email, :Sujet, :Message, :date)");
  if($req->execute(array(
          ":Nom" => $recup_nom,
  		":Email" => $recup_email,
  		":Sujet" => $recup_sujet,
  		":Message" => $recup_message,
      ":date"=>$currentTime
          ))){
  			 header('Location:validation.html');
    exit();
  }else{
  	header('Location:erreur.html');
  	exit();
  }
}else{
  header('Location:erreur.html');
  exit();
}
?>
