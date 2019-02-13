<?php

echo '
<div class="audioplayer">
    <div class="player">
        <div class="visuel"></div>
        <div class="infos">
            <div class="artiste">Nom de l\'artiste</div>
            <div class="titre">Nom du morceau</div>
        </div>
        <div class="waveform"></div>
        <div class="controls">
            <button class="prev">Précédent</button>
            <button class="play-pause play">Lecture</button>
            <button class="next">Suivant</button><span class="volume">
          <button class="volume_button volume-on" data-value="90">Volume</button><span class="volume_slider"><span
                class="volume_sliderTotale">
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
    </div>
</div>
<br>
<button id="push-subscription-button" disabled> Activation des nofifs </button><br>
<button id="send-push-button"> Envoi d\'une notification</button><br>
<br>
';
?>