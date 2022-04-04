<?php

namespace tweeterapp\view;

class TweeterView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe parent
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    private function renderHeader(){
        return '<h1>MiniTweeTR</h1><nav id="navbar"><a class="tweet-control" href=""><img alt="home" src="https://webetu.iutnc.univ-lorraine.fr/www/boumaza1/tweeter/04/html/home.png"></a><a class="tweet-control" href=""><img alt="login" src="https://webetu.iutnc.univ-lorraine.fr/www/boumaza1/tweeter/04/html/login.png"></a><a class="tweet-control" href=""><img alt="signup" src="https://webetu.iutnc.univ-lorraine.fr/www/boumaza1/tweeter/04/html/signup.png"></a></nav>';
    }
    
    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return 'La super app créée en Licence Pro &copy;2020';
    }

    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les Tweets. 
     *  
     */
    
    private function renderHome(){

        $html = '';
        $tweets = $this->data;   
        $requete = \tweeterapp\model\Tweet::select(); 
        $router = new \mf\router\Router();
        
        
        foreach ($tweets as $v) {
            $t = \tweeterapp\model\Tweet::where('id' ,'=', $v->id)->first();
            $author = $t->author()->first();

            $titre = "<h2>Les derniers Tweets</h2>";

            $html .= "<div class='tweet'><div class='tweet-text'><a href=\"" . $router->urlFor('view', [['id', $v->id]]) . "\">$v->text</a></div><div class='tweet-footer'><span class='tweet-timestamp'>$v->created_at</span> <span class='tweet-author'><a href=\"" . $router->urlFor('user', [['id', $v->author]]) . "\">$author->fullname</a></span></div></div>";
        }
        return $titre . $html;


        /*
         * Retourne le fragment HTML qui affiche tous les Tweets. 
         *  
         * L'attribut $this->data contient un tableau d'objets tweet.
         * 
         */
        
        
    }
  
    /* Méthode renderUeserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné. 
     * 
     */
     
    private function renderUserTweets(){

        $html = '';
        $userTweets = $this->data; 
        
        $router = new \mf\router\Router();

        foreach($_GET as $valeur) {
            $u = \tweeterapp\model\User::where('id', '=', $valeur)->first();
            $liste_tweets = $u->tweets()->get();

            $html = "<h2>Les tweets de $u->fullname</h2>";

            if (count($liste_tweets)>0) {
                foreach ($liste_tweets as $v) {
                    $html .= "<div class='tweet'><div class='tweet-text'><a href=\"" . $router->urlFor('view', [['id', $v->id]]) . "\">$v->text</a></div><div class='tweet-footer'><span class='tweet-timestamp'>$v->created_at</span> <span class='tweet-author'><a href=\"" . $router->urlFor('user', [['id', $v->author]]) . "\">$u->fullname</a></span></div></div>";
                }
            }

            else {
                $html = "Cet utilisateur n'a posté aucun tweet ! Il n'est pas très actif ! <br /><br />";
            }   
        }
        return $html;
        

        /* 
         * Retourne le fragment HTML pour afficher
         * tous les Tweets d'un utilisateur donné. 
         *  
         * L'attribut $this->data contient un objet User.
         *
         */
        
    }
  
    /* Méthode renderViewTweet 
     * 
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */
    
    private function renderViewTweet(){
        $html = '';
        $tweet = $this->data; 
        $router = new \mf\router\Router();

        foreach ($_GET as $valeur) {
            $requete = \tweeterapp\model\Tweet::select()->where('id', '=', $valeur)->first();   
            $author = $requete->author()->first();

            $html = "<div class='tweet'><div class='tweet-text'><a href=\"" . $router->urlFor('view', [['id', $requete->id]]) . "\">$requete->text</a></div><div class='tweet-footer'><span class='tweet-timestamp'>$requete->created_at</span> <span class='tweet-author'><a href=\"" . $router->urlFor('user', [['id', $requete->author]]) . "\">$author->fullname</a></span></div><div class='tweet-footer'><hr><span class='tweet-score tweet-control'>$requete->score</span></div></div>";
        }
        
        return $html;

        /* 
         * Retourne le fragment HTML qui réalise l'affichage d'un tweet 
         * en particulié 
         * 
         * L'attribut $this->data contient un objet Tweet
         *
         */
        
    }



    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */
    protected function renderPostTweet(){

        $router = new \mf\router\Router();

        $html = "<form action='http://localhost/antoninwinterstein/PHP/Tweeter/main.php/send/' method='post'>
        <div>
            <textarea type='text' name='postTweet' placeholder='Entrer tweet...'></textarea> <br /><br />
        </div>
        <div>
            <button name='bouton' type='submit'>Poster le tweet</button><br /><br />
        </div>
     </form>";

        return $html;
        
        /* Méthode renderPostTweet
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction 
         * d'un tweet, l'action (bouton de validation) du formulaire est la route "/send/"
         *
         */
        
    }


    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */
    
    protected function renderBody($selector){

        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        switch ($selector) {
            case "maison":
                $main = $this->renderHome();
                break;
            case "view":
                $main = $this->renderViewTweet();
                break;
            case "user":
                $main = $this->renderUserTweets();
                break;
            case "renderPostTweet":
                $main = $this->renderPostTweet();
                break;
        }
        
        $html = "
        <body>
            <header class='theme-backcolor1'>$header</header>
            <section class='theme-backcolor2'>
                <article>$main</article>
            </section>
            <footer class='theme-backcolor1'>$footer</footer>
        </body>";

        return $html;

        /*
         * voire la classe AbstractView
         * 
         */
        
    }
}
