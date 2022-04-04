<?php

require_once 'vendor/autoload.php';

require_once 'src/mf/utils/AbstractClassLoader.php';
require_once 'src/mf/utils/ClassLoader.php';

$loader = new \mf\utils\ClassLoader('src');
$loader->register();
\mf\view\AbstractView::addStyleSheet('html/style.css');


use \tweeterapp\model\Follow;
use \tweeterapp\model\Like;
use \tweeterapp\model\Tweet;
use \tweeterapp\model\User;

// Informations fichier ini IUT
// $config = parse_ini_file("conf/conf.ini");

// Informations fichier ini maison
$config = parse_ini_file("conf/conf_maison.ini");

/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* rendre la connexion visible dans tout le projet */
$db->bootEloquent();           /* établir la connexion */



// Récupérer tous les utilisateurs
// $requete = User::select();  /* SQL : select * from 'user' */
// $lignes = $requete->get();   /* exécution de la requête et plusieurs lignes résultat */
// foreach ($lignes as $v)      /* $v est une instance de la classe User */
//        echo "Identifiant = $v->id, Nom = $v->fullname<hr>" ;



// Récupérer tous les tweets
// $requete = Tweet::select();  /* SQL : select * from 'tweet' */
// $lignes = $requete->get();   /* exécution de la requête et plusieurs lignes résultat */  
// foreach ($lignes as $v)      /* $v est une instance de la classe Tweet */
//         echo "Identifiant = $v->id, Nom = $v->text<hr>" ;



// Récupérer la liste de tous les tweets ordonnées par date de modification
// $requete = Tweet::select()->orderBy('updated_at');   
// $lignes = $requete->get();  
// foreach ($lignes as $v)      
//        echo "Identifiant = $v->id, Nom = $v->text,  Modifié le = $v->updated_at<hr>" ;



// Récupérer la liste des Tweets qui ont un score positif 
// $requete = Tweet::select()->where('score', '>', 0);   
// $lignes = $requete->get();  
// foreach ($lignes as $v)      
//        echo "Identifiant = $v->id, Nom = $v->text, Score = $v->score<hr>" ;



// Ajouter un tweet à la base de données
// $tweet = new Tweet();
// $tweet->text = 'Test de création de tweet';
// $tweet->author = 2;
// $tweet->save();



// Ajouter un utilisateur à la liste des utilisateurs
// $user = new User();
// $user->fullname = 'Un Nouvel Utilisateur';
// $user->username = 'utilisateur';
// $user->password = 'azerty';
// $user->level = 100;
// $user->followers = 0;
// $user->save();



// Retourne l'auteur du tweet avec l'ID 53
// $t = Tweet::where('id' ,'=', 53)->first();
// $author = $t->author()->first();
// echo $author . '<br /><br />';



// Retourne tous les tweets pour l'utilisateur à l'ID 1
// $u = User::where('id', '=', 1)->first();
// $liste_tweets = $u->tweets()->get();
// foreach ($liste_tweets as $v)      
//         echo "Texte = $v->text, <br /> Nom = $u->fullname<hr>";



// Retourne les utilisateurs qui ont apprécié le Tweet (FONCTIONNE PAS)
// $c = Tweet::where('id' ,'=', 53)->first();
// $liste_utilisateurs = $c->likedBy()->get();
// echo $liste_utilisateurs;


// Implantation du contrôleur
// $ctrl = new tweeterapp\control\TweeterController();
// echo $ctrl->viewHome();


$router = new \mf\router\Router();

$router->addRoute('maison',
                  '/home/',
                  '\tweeterapp\control\TweeterController',
                  'viewHome');

$router->addRoute('view',
                  '/view/',
                  '\tweeterapp\control\TweeterController',
                  'viewTweet');

$router->addRoute('user',
                  '/user/',
                  '\tweeterapp\control\TweeterController',
                  'viewUserTweets');

$router->addRoute('testelse',
                  '/test/',
                  '\tweeterapp\control\TweeterController',
                  'viewHome');

$router->addRoute('post',
                  '/post/',
                  '\tweeterapp\control\TweeterController',
                  'viewPostTweet');

$router->addRoute('send',
                  '/send/',
                  '\tweeterapp\control\TweeterController',
                  'postTweet');

$router->setDefaultRoute('/home/');

//print_r(\mf\router\Router::$routes);
//print_r(\mf\router\Router::$aliases);

//echo "<a href=\"" . $router->urlFor('view', [['id', 61]]) . "\">Le tweet</a> <br />";

//echo "<a href=\"" . $router->urlFor('user', [['id', 1]]) . "\">L'user</a>";


$router->run();

