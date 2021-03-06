<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PlayerMP3">
    <meta name="author" content="Work in Progress">
    <title>Fasma</title>
    <!-- Custom styles for this template-->
    <link rel="stylesheet" media="screen and (min-width: 600px)" href="public/stylesheets/player.css">
    <link rel="stylesheet" media="screen and (max-width: 600px)" href="public/stylesheets/player_mobile.css">
	<style>body{margin:0}</style>
  </head>
  <body>
    <div class="audioplayer">
      <div class="player">
        <div class="visuel"></div>
        <div class="infos">
          <div class="artiste">Nom de l'artiste</div>
          <div class="titre">Nom du morceau</div>
        </div>
        <div class="waveform"></div>
        <div class="controls">
          <button class="prev">Précédent</button>
          <button class="play-pause play">Lecture</button>
          <button class="next">Suivant</button><span class="volume">
            <button class="volume_button volume-on" data-value="90">Volume</button><span class="volume_slider"><span class="volume_sliderTotale">
                <input class="volume-input-range" type="range" min="0" max="100" value="50"></span></span></span>
        </div>
        <div class="temps">
          <div class="en-cours">0:00</div>
          <div class="total">3:11</div>
        </div>
        <div class="statistiques">
          <div class="nb-lectures">16,5M</div>
          <div class="nb-commentaires">280</div>
        </div>
        <div class="social">
          <button class="like">333K</button>
          <button class="share">Partager</button>
        </div>
        <!-- Modal-->
        <div class="modal">
          <div class="modal-content">
            <div class="modal-header"><span class="close">×</span>
              <p>Intégrer le player</p>
            </div>
            <div class="modal-body">
              <p>Code d'intégration :</p>
              <input class="share-input-text" type="text" value="" readonly="readonly">
            </div>
            <div class="modal-footer"><a>Copier</a></div>
          </div>
        </div>
      </div>
    </div>
    <script src="../../public/javascripts/script/soundmanager2.js"></script>
    <script src="../../public/javascripts/PlayerUtils.js"></script>
    <script src="../../public/javascripts/Connexion.js"></script>
    <script src="../../public/javascripts/spectre.js"></script>
    <script src="../../public/javascripts/Music.js"></script>
    <script src="../../public/javascripts/Playlist.js"></script>
    <script src="../../public/javascripts/Player.js"></script>
	
    <script>
window.onload = function () {
    let music0 = new Music({
        "id": 3,
        "titre": "Zero",
        "album": "Origins",
        "artiste": "Imagine Dragons",
        "cheminMP3": "../public/musics/Imagine_Dragons/Zero.mp3",
        "cover": "../public/images/Imagine_Dragons/Zero.jpg",
        "annee": 2018,
        "duree": 228,
        "genre": ["Pop rock", "Rock alternatif"],
        "listePoint": [0, 0, 3, 4, 9, 13, 16, 20, 21, 21, 21, 22, 21, 25, 26, 26, 26, 23, 17, 26, 29, 65, 97, 104, 101, 105, 104, 100, 100, 97, 111, 106, 107, 99, 101, 102, 104, 100, 113, 108, 103, 95, 107, 110, 108, 104, 102, 112, 103, 89, 96, 97, 97, 94, 112, 113, 102, 82, 102, 99, 104, 88, 103, 104, 96, 95, 106, 97, 98, 101, 98, 105, 98, 89, 100, 108, 111, 107, 95, 101, 102, 109, 108, 114, 82, 63, 109, 99, 85, 109, 109, 106, 95, 81, 84, 82, 77, 80, 95, 93, 95, 86, 92, 88, 89, 83, 100, 91, 103, 97, 105, 103, 108, 97, 86, 85, 81, 82, 90, 88, 99, 93, 86, 98, 86, 95, 87, 73, 110, 95, 110, 105, 110, 91, 105, 111, 98, 94, 102, 111, 104, 98, 106, 110, 109, 107, 108, 109, 110, 112, 111, 108, 95, 98, 105, 109, 107, 82, 95, 112, 102, 97, 104, 109, 103, 89, 103, 109, 101, 92, 93, 109, 100, 95, 102, 103, 110, 85, 105, 112, 105, 97, 110, 107, 113, 88, 109, 118, 107, 98, 111, 74, 79, 107, 114, 101, 109, 116, 111, 112, 111, 104, 115, 105, 111, 109, 105, 105, 106, 107, 107, 98, 110, 110, 106, 108, 107, 103, 108, 112, 111, 109, 111, 93, 110, 112, 108, 105, 98, 101, 103, 110, 107, 110, 112, 109, 77, 58, 61, 52, 44, 44, 43, 38, 52, 54, 53, 61, 46, 51, 66, 56, 55, 60, 56, 50, 51, 54, 39, 60, 50, 47, 43, 49, 39, 50, 52, 48, 58, 59, 61, 59, 49, 58, 48, 49, 36, 33, 25, 21, 22, 16, 16, 59, 114, 108, 112, 111, 110, 110, 111, 105, 109, 118, 116, 105, 108, 108, 112, 111, 106, 106, 109, 103, 108, 111, 113, 104, 104, 106, 108, 113, 110, 108, 106, 111, 108, 103, 108, 108, 110, 108, 110, 111, 103, 109, 100, 103, 102, 81, 89, 103, 99, 83, 94, 86, 90, 97, 97, 68, 73, 102, 94, 96, 100, 58, 89, 99, 105, 92, 94, 88, 99, 93, 101, 94, 92, 98, 93, 102, 86, 77, 100, 96, 93, 85, 80, 65, 67, 109, 105, 111, 90, 110, 95, 99, 89, 108, 107, 109, 98, 107, 100, 108, 107, 97, 98, 103, 83, 107, 103, 108, 92, 100, 103, 105, 103, 104, 110, 99],
        "nbEcoute": 0,
        "nbLike": 0,
        "nbPartage": 0,
        "nbComment": 0
    });

    let music1 = new Music({
        "id": 1,
        "titre": "Something Just Like This",
        "album": "Something Just Like This",
        "artiste": "The Chainsmokers & Coldplay",
        "cheminMP3": "../public/musics/The_Chainsmokers_&_Coldplay/Something_Just_Like_This.mp3",
        "cover": "../public/images/The_Chainsmokers_&_Coldplay/Something_Just_Like_This.jpg",
        "annee": 2017,
        "duree": 248,
        "genre": ["Pop rock", "Rock alternatif", "Danse"],
        "listePoint": [2, 2, 1, 4, 4, 3, 4, 5, 3, 4, 4, 4, 4, 13, 14, 15, 11, 16, 16, 14, 8, 12, 17, 14, 9, 15, 17, 13, 12, 19, 18, 18, 15, 17, 20, 16, 11, 19, 26, 24, 21, 19, 17, 29, 25, 30, 30, 26, 30, 30, 23, 31, 26, 37, 29, 28, 30, 28, 26, 34, 39, 30, 30, 39, 37, 30, 34, 30, 30, 27, 35, 35, 33, 34, 36, 42, 38, 37, 35, 43, 33, 34, 37, 37, 29, 37, 38, 40, 34, 36, 38, 37, 34, 43, 52, 44, 36, 40, 46, 42, 36, 41, 44, 42, 43, 40, 41, 50, 36, 34, 31, 35, 34, 41, 23, 40, 25, 39, 29, 51, 47, 50, 47, 43, 34, 41, 36, 42, 48, 34, 42, 29, 45, 30, 50, 51, 46, 33, 36, 39, 39, 29, 34, 37, 35, 27, 41, 33, 34, 33, 30, 38, 40, 36, 30, 35, 34, 26, 28, 36, 36, 38, 40, 34, 45, 45, 50, 43, 42, 46, 47, 39, 42, 36, 51, 42, 40, 45, 41, 39, 50, 53, 38, 40, 48, 42, 39, 42, 38, 34, 38, 45, 37, 44, 45, 50, 53, 51, 53, 30, 42, 23, 39, 38, 38, 26, 37, 27, 37, 40, 48, 53, 51, 54, 38, 41, 32, 42, 41, 46, 33, 42, 30, 42, 46, 53, 53, 40, 37, 11, 12, 8, 5, 8, 8, 6, 7, 9, 12, 10, 10, 9, 11, 10, 12, 14, 14, 8, 11, 12, 12, 10, 13, 16, 16, 13, 35, 37, 33, 33, 45, 39, 30, 39, 37, 39, 35, 36, 34, 37, 31, 32, 49, 30, 35, 43, 43, 40, 41, 45, 45, 36, 41, 44, 37, 48, 49, 52, 55, 44, 38, 35, 35, 32, 34, 33, 34, 33, 34, 38, 32, 35, 31, 33, 33, 35, 33, 35, 36, 35, 36, 40, 37, 38, 42, 57, 53, 55, 60, 50, 39, 46, 37, 45, 47, 45, 43, 45, 38, 45, 40, 43, 47, 49, 39, 41, 43, 42, 47, 46, 48, 43, 46, 37, 48, 56, 58, 56, 57, 59, 48, 43, 48, 44, 46, 49, 42, 48, 37, 49, 42, 45, 48, 50, 41, 41, 40, 46, 38, 42, 49, 46, 49, 42, 51, 48, 67, 57, 55, 29, 15, 4, 7, 2, 4, 3, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        "nbEcoute": 0,
        "nbLike": 0,
        "nbPartage": 0,
        "nbComment": 0
    });

    var p = new Player(document.querySelector('.audioplayer'));

    p.addMusicObject(music0);
    p.addMusicObject(music1);
    p.addMusicObject(music1);
    p.addMusicObject(music0);
    p.addMusicObject(music0);
    p.addMusicObject(music0);
    p.addMusicObject(music1);
    p.addMusicObject(music1);
};
	</script>
  </body>
</html>