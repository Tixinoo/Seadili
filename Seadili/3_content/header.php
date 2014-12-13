<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="SeaDiLi-Team" />
        <title>SeaDiLi</title>
        <link rel="stylesheet" href="4_style/style_1.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Yeseva+One' rel='stylesheet' type='text/css'/>
        <link href='http://fonts.googleapis.com/css?family=Lustria' rel='stylesheet' type='text/css'/>
        <script type="text/javascript" src="libraries/jquery-1.11.1.min.js"></script>

        <script>

            function playTrack(mp3url) {
                console.log("toto");
                console.log(mp3url);
                /*var audioplayer = document.getElementById("audioplayer");
                audioplayer.setAttribute("src", mp3url);
                audioplayer.load();
                audioplayer.play();*/
        
                //var source = document.getElementsByTagName("source")[0];
                
                var audioplayer = document.getElementsByTagName("audio")[0];
                                
                audioplayer.setAttribute("src", mp3url);
                
                audioplayer.pause();
                audioplayer.load();
                audioplayer.play();
                
                
                //document.getElementById("audioplayer").innerHTML = "toto";
                //document.getElementById("audioplayer").setAttribute("src", mp3url);
                console.log("coucou");
            }

            function addtrackplaylist(trackid, tracktitle) {
                document.getElementById("playlistcurrent").innerHTML = document.getElementById("playlistcurrent").innerHTML + "- (" + trackid + ") " + tracktitle + "<br/>";
                document.getElementById("playlistadd").innerHTML = document.getElementById("playlistadd").innerHTML + "<input type=\"hidden\" name=\"tracks[]\" value=\"" + trackid + "\">";
                console.log("ahah");
            }

            function playlist(id) {
                identifiant = "pcontent" + id;
                if (document.getElementById(identifiant).style.display == "none") {
                    document.getElementById(identifiant).style.display = "block";
                }
                else {
                    document.getElementById(identifiant).style.display = "none";
                }

            }

            function search() {
                var input = $("#rechercher").val();
                $("#resultats").html("<p>Résultats pour " + input + "</p>");
                jQuery.ajax({
                    url: 'index.php',
                    data: {a: 'searchArtists', val: input},
                    type: 'get',
                    success: function (res) {
                        $("#resultatsArtistes").html(res);
                    }
                });
                jQuery.ajax({
                    url: 'index.php',
                    data: {a: 'searchTracks', val: input},
                    type: 'get',
                    success: function (res) {
                        $("#resultatsTitres").html(res);
                    }
                });
            }
            
            function menu(nom) {
                switch(nom) {
                    case 'home':
                        var e = document.getElementById("h");
                        e.style.backgroundColor = "red";
                        console.log("ici");
                        break;
                    case 'playlists':
                        break;
                    case 'register':
                        break;
                }
            }

        </script>

    </head>

    <body>

        <?php include '3_content/connecting_bar.php'; ?>

        <title> 
            SeaDiLi 
        </title>
        
        <div id="player">
            <audio src="http://freedownloads.last.fm/download/86630288/Omnipresent.mp3" controls="controls">
            </audio>
        </div>

        <div class="titre"> 
            <h1>SeaDiLi</h1>
            <h4>Search.Discover.Listen</h4>
        </div>

        <div class="menu">
            <a href="index.php?a=home" ><div id ="h" class="lienhome"><img onclick="menu('home')" height="35px" src="http://localhost/Seadili/Seadili/5_images/home.png"/></div></a>
            <a id ="p" href="index.php?a=playlists" onclick="menu('playlists')"><div class="lienplaylist"><img height="35px" src="http://localhost/Seadili/Seadili/5_images/playlist.png"/></div></a>
            <a id ="r" href="index.php?a=register" onclick="menu('register')"><div class="lienenreg"><img height="35px" src="http://localhost/Seadili/Seadili/5_images/register.png"/></div></a>
        </div>
        
        <div id="playlistcurrent">
        </div>

        <form action="0_model/playlistadd.php" method="POST">
            <div id="playlistadd">
            </div>
            <input class="newPlaylist" type="submit" name="nouvellePlaylist" value="Créer Playlist"/>
            <input class="nomNewPlaylist" type="text" name="nomNouvellePlaylist" value="Nom de la Playlist"/>
        </form>
