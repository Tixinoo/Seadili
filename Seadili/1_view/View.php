<?php

include_once '0_model/User.php';
include_once '0_model/Track.php';

class View {
    /*
     * Objet à afficher
     */

    private $obj0, $obj1, $obj2;

    function __construct($p0, $p1, $p2) {
        $this->obj0 = $p0;
        $this->obj1 = $p1;
        $this->obj2 = $p2;
    }

    public function defaultView() {
        include '3_content/header.php';

        include '3_content/home.html';

        echo "<div style=\"display:inline-block; float:left; width:58%; \">";
        echo "<h2>Titres</h2><hr><br><div id=\"resultatsTitres\">";
        foreach (Track::findRandom(3) as $track) {
            $this->trackView($track);
        }
        echo "</div>";
        echo "<h2>Artites</h2><hr><br><div id=\"resultatsArtistes\">";
        foreach (Artist::findRandom(3) as $artist) {
            $this->artistView($artist);
        }
        echo "</div>";
        /* echo "<h2>Playlists</h2><hr><br><div id=\"resultatsPlaylists\">";
          foreach (Playlist::findRandom(3) as $playlist) {
          $this->playlistView($playlist);
          }
          echo "</div>"; */
        echo "</div>";

        /* echo "<div style=\"display:inline-block; float:right; width:39%; margin:auto;\">";
          echo "<h2>Votre écoute</h2><hr><br>";
          include '3_content/player.html';
          echo "\n";
          echo "</div>"; */

        echo "<div style=\"display:inline-block; float:right; width:39%; margin:auto;\">";
        echo "<h2>Votre nouvelle playlist</h2><hr><br>";
        include '3_content/newplaylist.html';
        echo "</div>";

        echo "<div style=\"display:inline; float:right; width:100%;\">";
        include '3_content/footer.html';
        echo "</div>";
    }

    public function olddefaultView() {
        include '3_content/header.php';
        include '3_content/home.html';
        //Affichage de 10 titres aléatoires
        echo "<h2>Titres</h2><hr><br><div id=\"resultatsTitres\">";
        for ($i = 0; $i < 3; $i++) {
            $this->trackView($this->obj0[rand(0, count($this->obj0) - 1)]);
        }
        //foreach ($this->obj0 as $track) {
        //$this->trackView($track);
        //}
        echo "</div>";

        //Affichage de 10 artistes aléatoires
        echo "<h2>Artites</h2><hr><br><div id=\"resultatsArtistes\">";
        for ($i = 0; $i < 3; $i++) {
            $this->artistView($this->obj1[rand(0, count($this->obj1) - 1)]);
        }
        //foreach ($this->obj1 as $artist) {
        //$this->artistView($artist);
        //}
        echo "</div>";

        //Affichage de toutes les playlists
        echo "<h2>Playlists</h2><hr><br><div id=\"resultatsPlaylists\">";
        foreach ($this->obj2 as $playlist) {
            $this->playlistView($playlist);
        }
        echo "</div>";

        include '3_content/footer.html';
    }

    public function playlistsView() {
        include '3_content/header.php';
        include '3_content/playlists.html';

        echo
        "<div class=\"decouverte\">
            <h2>Decouvrir...</h2>
            <div class=\"Dplaylist\" id=1 onclick=\"playlist(this.id)\">
                Playlist 1<input type=\"button\" class=\"add\" value=\"+\">
            </div>
            <div class=\"playlistcontent\" id=\"pcontent1\"> 
                Morceau 1
                <br>Morceau 2
            </div>
            
            <div class=\"Dplaylist\" id=2 onclick=\"playlist(this.id)\">
                Playlist 2<input type=\"button\" class=\"add\" value=\"+\">
            </div>
            <div class=\"playlistcontent\" id=\"pcontent2\"> 
                Morceau 1
                <br>Morceau 2
            </div>
        </div>";

        if (isset($_SESSION['user'])) {
            $u = new User();
            $u = $_SESSION['user'];
            $t = Playlist::findByUserid($u->user_id);
            foreach ($t as $pl) {
                $this->playlistView($pl);
            }
        }


        include '3_content/footer.html';
    }

    public function registerView() {
        include '3_content/header.php';
        include '3_content/register.html';
        include '3_content/footer.html';
    }

    // Méthodes d'affichage des différents éléments

    /**
     * Affiche un artiste
     * @param $artist Artiste à afficher
     */
    public function artistView($artist) {
        echo"<div class=\"artiste\">" . $artist->name . "
        <br><img src=\"" . $artist->image_url . "\" height=\"100px\"/>";
        echo "<br><button style=\"background-color: white; border: 0px;\" class=\"easy-modal-open\" href=\"#artistinfo" . $artist->artist_id . "\"><img height=\"20px\" src=\"http://localhost/Seadili/Seadili/5_images/info.png\" height=\"100px\"/></button>\n";
        /* echo "<!--<br>Info : " . $artist->info . "-->
          <br><input type=\"image\" height=\"20px\" src=\"http://localhost/Seadili/Seadili/5_images/info.png\" value=\"Info\">"; */
        echo "</div>";
        
        echo "<div class=\"easy-modal\" id=\"artistinfo" . $artist->artist_id . "\">\n";
        echo "<br><div class=\"infoartist\">";
        echo "<b>" . $artist->name . "</b>";
        echo "<br><br><img src=\"" . $artist->image_url . "\" height=\"100px\"/>";
        echo "<br><br><i>" . $artist->info . "</i></div>";
        echo "</div>\n";
    }

    /**
     * Affiche un artiste
     * @param $artist Artiste à afficher
     */
    public function artistView2($artist) {
        $str = "<div class=\"artiste\">" . $artist->name . "
        <br><img src=\"" . $artist->image_url . "\" height=\"100px\"/>
        <br>Info : " . $artist->info . "
        </div>";
        return $str;
    }

    public function artistsView($artists) {
        $str = "";
        foreach ($artists as $artist) {
            $str.= $this->artistView2($artist);
        }
        return $str;
    }

    /**
     * Affiche un titre
     * @param $track Titre à afficher
     */
    public function trackViewGOOD($track) {
        echo"<div class=\"morceau\">" . $track->title;
        echo
        "<form name=\"addtrack\" method=\"POST\">
	<input type=\"button\" value=\"Ajouter\"  onclick=\"addtrackplaylist(" . $track->track_id . ",'" . $track->title . "')\">
        </form>";
        $artist = Artist::findById($track->artist_id);
        echo "<i>" . $artist->name . "</i>
        <!--<br><audio controls=\"controls\"><source src=" . $track->mp3_url . "/></audio>-->
        <br><input type=\"button\" value=\"Lire\" onclick=\"playTrack('" . $track->mp3_url . "')\">
        </div>";
    }

    /**
     * Affiche un titre
     * @param $track Titre à afficher
     */
    public function trackView($track) {
        $artist = Artist::findById($track->artist_id);
        echo"<div class=\"morceau\">";
        echo "<input type=\"image\" height=\"25px\" src=\"http://localhost/Seadili/Seadili/5_images/play.png\" value=\"Lire\" onclick=\"playTrack('" . $track->mp3_url . "')\"><br>";
        echo $track->title;
        echo "<br><i>" . $artist->name . "</i>";
        echo "<br><input type=\"image\" height=\"27px\" src=\"http://localhost/Seadili/Seadili/5_images/add.png\" value=\"Ajouter\" onclick=\"addtrackplaylist(" . $track->track_id . ",'" . $track->title . "')\">";
        echo "</div>";
    }

    /**
     * Affiche un titre
     * @param $track Titre à afficher
     */
    public function tttrackView($track) {
        $artist = Artist::findById($track->artist_id);
        echo"<div class=\"morceau\">";
        echo "<input type=\"image\" height=\"20px\" src=\"http://localhost/Seadili/Seadili/5_images/play.png\" value=\"Lire\" onclick=\"playTrack('" . $track->mp3_url . "')\">";
        echo "<br>" . $track->title;
        echo "<br><i>" . $artist->name . "toto</i>";
        echo
        "<form name=\"addtrack\" method=\"POST\">
	<input type=\"image\" height=\"25px\" src=\"http://localhost/Seadili/Seadili/5_images/add.png\" value=\"Ajouter\"  onclick=\"addtrackplaylist(" . $track->track_id . ",'" . $track->title . "')\">        
        </form>";
        echo "</div>";
    }

    /**
     * Affiche un titre
     * @param $track Titre à afficher
     */
    public function trackView2($track) {
        $str = "<div class=\"morceau\">" . $track->title;
        $str.=
                "<form name=\"addtrack\" method=\"POST\">
	<input type=\"button\" value=\"Ajouter\"  onclick=\"addtrackplaylist(" . $track->track_id . ",'" . $track->title . "')\">
        </form>";
        $artist = Artist::findById($track->artist_id);
        $str.= "<i>" . $artist->name . "</i>
        <br><audio controls=\"controls\"><source src=" . $track->mp3_url . "/></audio>
        <br><input type=\"button\" value=\"Lire\" onclick=\"playTrack('" . $track->mp3_url . "')\">
        </div>";
        return $str;
    }

    public function tracksView($tracks) {
        $str = "";
        foreach ($tracks as $track) {
            $str.= $this->trackView2($track);
        }
        return $str;
    }

    /**
     * Affiche une playlist
     * @param $playlist Playlist à afficher
     */
    public function playlistView($playlist) {
        echo"<div class=\"playlist\">" . $playlist->playlist_name . "
        <br><i>Created by ..</i>";
        $tracks = Track::findByPlaylist($playlist->playlist_id);
        foreach ($tracks as $track) {
            $this->trackView($track);
        }
        echo "</div>";
    }

}
