<?php

namespace tweeterapp\control;

/* Classe TweeterController :
 *  
 * Réalise les algorithmes des fonctionnalités suivantes: 
 *
 *  - afficher la liste des Tweets 
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur 
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis 
 *  - évaluer un Tweet
 *  - suivre un utilisateur
 *   
 */

class TweeterController extends \mf\control\AbstractController {


    /* Constructeur :
     * 
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     * 
     */
    
    public function __construct(){
        parent::__construct();
    }


    /* Méthode viewHome : 
     * 
     * Réalise la fonctionnalité : afficher la liste de Tweet
     * 
     */
    
    public function viewHome(){

        $tweets = \tweeterapp\model\Tweet::all();
        $vue = new \tweeterapp\view\TweeterView($tweets);
        // echo $vue->renderHome();
        
        $vue->render('maison');
        
        

        /* Algorithme :
         *  
         *  1 Récupérer tout les tweet en utilisant le modèle Tweet
         *  2 Parcourir le résultat 
         *      afficher le text du tweet, l'auteur et la date de création
         *  3 Retourner un block HTML qui met en forme la liste
         * 
         */

    }


    /* Méthode viewTweet : 
     *  
     * Réalise la fonctionnalité afficher un Tweet
     *
     */
    
    public function viewTweet(){

        $tweet = \tweeterapp\model\Tweet::all();
        $vue = new \tweeterapp\view\TweeterView($tweet);
        // echo $vue->renderViewTweet();

        $vue->render('view');

        /* Algorithme : 

        http:// ... /Tweeter/main.php/view/?id=13

         *  
         *  1 L'identifiant du Tweet en question est passé en paramètre (id) 
         *      d'une requête GET 
         *  2 Récupérer le Tweet depuis le modèle Tweet
         *  3 Afficher toutes les informations du tweet 
         *      (text, auteur, date, score)
         *  4 Retourner un block HTML qui met en forme le Tweet
         * 
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */

    }


    /* Méthode viewUserTweets :
     *
     * Réalise la fonctionnalité afficher les tweet d'un utilisateur
     *
     */
    
    public function viewUserTweets(){

        $userTweets = \tweeterapp\model\Tweet::all();
        $vue = new \tweeterapp\view\TweeterView($userTweets);
        // echo $vue->renderUserTweets();

        $vue->render('user');

        /*

        http:// .../Tweeter/main.php/user/?id=2
         *
         *  1 L'identifiant de l'utilisateur en question est passé en 
         *      paramètre (id) d'une requête GET 
         *  2 Récupérer l'utilisateur et ses Tweets depuis le modèle 
         *      Tweet et User
         *  3 Afficher les informations de l'utilisateur 
         *      (non, login, nombre de suiveurs) 
         *  4 Afficher ses Tweets (text, auteur, date)
         *  5 Retourner un block HTML qui met en forme la liste
         *
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */
        
    }

    public function viewPostTweet() {
        $vue = new \tweeterapp\view\TweeterView(null);
        $vue->render('renderPostTweet');
    }

    public function postTweet() {
        $tweet = new \tweeterapp\model\Tweet();
        $tweet->text = $_POST['postTweet'];
        $tweet->author = 2;
        $tweet->save();
    }
}
