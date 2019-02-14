/**
 * Class will generate the superPlayer Dom
 * @param {ElementNode} domElement - DOM Element on the page
 */
function SuperPlayerDom(domElement) {

    let constructor = function (domElement) {
        this.domElement = domElement;
        generateSuperPlayerDOM();

    }.bind(this);

    /**
     * Use to Generate SuperPlayer Html DOM
     * @namespace private
	 * @param domElement Element DOM correspondant au player
     */
    let generateSuperPlayerDOM = function () {
        this.domElement.appendChild(generateSuperPlayerDOM_Controls());
        this.domElement.appendChild(generateSuperPlayerDOM_Visuel());
        this.domElement.appendChild(generateSuperPlayerDOM_Timer());
        this.domElement.appendChild(generateSuperPlayerDOM_Controls2());
        this.domElement.appendChild(generateSuperPlayerDOM_Menu());
        this.domElement.appendChild(generateSuperPlayerDOM_MenuPannel());
        this.domElement.appendChild(generateSuperPlayerDOM_Playlist());
        this.domElement.appendChild(generateSuperPlayerDOM_PlaylistPannel());


    }.bind(this);

    let generateSuperPlayerDOM_Controls = function(){
        var divControls = document.createElement('div');
        divControls.classList.add('controls');
        var prevButton = document.createElement('button');
        prevButton.classList.add('prev');
        divControls.appendChild(prevButton);
        var playPauseButton = document.createElement('button');
        playPauseButton.classList.add('play-pause');
        playPauseButton.classList.add('play');
        playPauseButton.setAttribute('data-currentMusicId', '0');
        divControls.appendChild(playPauseButton);
        var nextButton = document.createElement('button');
        nextButton.classList.add('next');
        divControls.appendChild(nextButton);

        return divControls;
    };

    let generateSuperPlayerDOM_Visuel = function(){
        var divVisuel = document.createElement('div');
        divVisuel.classList.add('visuel');
        var cover = document.createElement('img');
        cover.classList.add('pochette');
        divVisuel.appendChild(cover);

        return divVisuel;
    };

    let generateSuperPlayerDOM_Timer = function() {
        var divTimer = document.createElement('div');
        divTimer.classList.add('timer');

            //INFOS
        var divInfos = document.createElement('div');
        divInfos.classList.add('infos');

        var divInfosArtitste = document.createElement('div');
        divInfosArtitste.classList.add('artiste');
        var divInfosTitre = document.createElement('div');
        divInfosTitre.classList.add('titre');
        divInfos.appendChild(divInfosArtitste);
        divInfos.appendChild(divInfosTitre);
            //SOCIAL
        var divSocial = document.createElement('div');
        divSocial.classList.add('social');

        var divSocialShare = document.createElement('div');
        divSocialShare.classList.add('share');
        var shareButton = document.createElement('button');
        shareButton.classList.add('share-button');
        // shareButton.addEventListener('click', function(e){
        //     var sharePannel = document.querySelector('.audioplayer-mini .timer .social .share .share-pannel');
        //     if (sharePannel.classList.contains("share-visible")) {
        //         sharePannel.classList.remove("share-visible");
        //         sharePannel.classList.add("share-hidden");
        //     } else {
        //         sharePannel.classList.remove("share-hidden");
        //         sharePannel.classList.add("share-visible");
        //     }
        // }, true );

        var divSharePannel = document.createElement('div');
        divSharePannel.classList.add('share-pannel');
        divSharePannel.classList.add('share-hidden');
        var divShareHeader = document.createElement('div');
        divShareHeader.classList.add('share-header');
        divShareHeader.innerHTML = "<p>Intégrer le player</p>";
        var divShareBody = document.createElement('div');
        divShareBody.classList.add('share-body');
        divShareBody.innerHTML = "<p>Code d'intégration :</p>";
        var divShareBodyInput = document.createElement('input');
        divShareBodyInput.classList.add('share-input-text');
        divShareBodyInput.setAttribute('readonly', 'readonly');
        divShareBodyInput.setAttribute('type', 'text');
        divShareBodyInput.setAttribute('value', '');
        divShareBody.appendChild(divShareBodyInput);
        var copyShareButton = document.createElement('button');
        copyShareButton.classList.add('copy-button');
        divSharePannel.appendChild(divShareHeader);
        divSharePannel.appendChild(divShareBody);
        divSharePannel.appendChild(copyShareButton);

        divSocialShare.appendChild(divSharePannel);
        divSocialShare.appendChild(shareButton);
        var likeButton = document.createElement('button');
        likeButton.classList.add('like-button');

        divSocial.appendChild(divSocialShare);
        divSocial.appendChild(likeButton);
            //TEMPS
        var divTemps = document.createElement('div');
        divTemps.classList.add('temps');

        var divTempsEnCours = document.createElement('div');
        divTempsEnCours.classList.add('en-cours');
        divTemps.appendChild(divTempsEnCours);

        var divTempsProgresseBar = document.createElement('div');
        divTempsProgresseBar.classList.add('progress-bar');
        divTempsProgresseBar.addEventListener("click", function(e){
            let rect = e.currentTarget.firstChild.getBoundingClientRect();
            let posX = e.clientX - rect.left;
            let beforeSize = this.domElement.querySelector(".audioplayer-mini .timer .temps .progress-bar .before-time").getBoundingClientRect().width;
            let afterSize = this.domElement.querySelector(".audioplayer-mini .timer .temps .progress-bar .after-time").getBoundingClientRect().width;
            let progressBarSize = beforeSize + afterSize;
            let percentile = posX / (progressBarSize);
            let time = parseInt(this.domElement.superPlayer.playlist.getCurrentMusic().duration);
            if (percentile > 1) {
                percentile = 1;
            }else if (percentile < 0){
                percentile = 0;
            }
            let newTime = time * percentile;
            e.currentTarget.style.setProperty('--pourcent', percentile*100);
            this.domElement.superPlayer.goTo(newTime);
        }.bind(this));
        divTempsProgresseBar.addEventListener("mouseover", function(e){
            let presentTime = e.currentTarget.querySelector(".present-time");
            if (!presentTime.classList.contains('is-active')) {
                presentTime.classList.add('is-active');
            }
        }.bind(this));
        divTempsProgresseBar.addEventListener("mouseout", function(e){
            let presentTime = e.currentTarget.querySelector(".present-time");
            if (presentTime.classList.contains('is-active')) {
                presentTime.classList.remove('is-active');
            }
        }.bind(this));

        var divTempsProgresseBarBefore = document.createElement('div');
        divTempsProgresseBarBefore.classList.add('before-time');
        var divTempsProgresseBarCurrent = document.createElement('div');
        divTempsProgresseBarCurrent.classList.add('present-time');
        var divTempsProgresseBarAfter = document.createElement('div');
        divTempsProgresseBarAfter.classList.add('after-time');
        divTempsProgresseBar.appendChild(divTempsProgresseBarBefore);
        divTempsProgresseBar.appendChild(divTempsProgresseBarCurrent);
        divTempsProgresseBar.appendChild(divTempsProgresseBarAfter);
        divTemps.appendChild(divTempsProgresseBar);

        var divTempsTotal = document.createElement('div');
        divTempsTotal.classList.add('total');
        divTemps.appendChild(divTempsTotal);

        divTimer.appendChild(divInfos);
        divTimer.appendChild(divSocial);
        divTimer.appendChild(divTemps);

        return divTimer;
    }.bind(this);

    let generateSuperPlayerDOM_Controls2 = function() {
        var divControls2 = document.createElement('div');
        divControls2.classList.add('controls2');

        var repeatButton = document.createElement('button');
        repeatButton.classList.add('repeat-button');
        repeatButton.addEventListener("click", function(e){
            let state = "is-active";
            if (e.currentTarget.classList.item(1) == null) {
                e.currentTarget.classList.add(state);
                console.log("aze");
                if (e.currentTarget.nextSibling.classList.item(1) !== null) {
                    e.currentTarget.nextSibling.classList.remove(state);
                }
            }else{
                e.currentTarget.classList.remove(state);
            }
        });
        // repeatButton.style.visibility = "hidden";
        var randomButton = document.createElement('button');
        randomButton.classList.add('random-button');
        randomButton.addEventListener("click", function(e){
            let state = "is-active";
            if (e.currentTarget.classList.item(1) == null) {
                e.currentTarget.classList.add(state);
                if (e.currentTarget.previousSibling.classList.item(1) !== null) {
                    e.currentTarget.previousSibling.classList.remove(state);
                }
            }else{
                e.currentTarget.classList.remove(state);
            }
        });
        // randomButton.style.visibility = "hidden";
        var spanVolume = document.createElement('span');
        spanVolume.classList.add('volume');
        var volumeButton = document.createElement('button');
        volumeButton.classList.add('volume-button');
        volumeButton.classList.add('volume-moyen2');
        volumeButton.addEventListener('mouseover', function(e){
            var volumePannel = document.querySelector('.audioplayer-mini .controls2 .volume .volume-slider');
            if (volumePannel.classList.contains("volume-visible")) {
                volumePannel.classList.remove("volume-visible");
                volumePannel.classList.add("volume-hidden");
            } else {
                volumePannel.classList.remove("volume-hidden");
                volumePannel.classList.add("volume-visible");
            }
        }, true );
        spanVolume.appendChild(volumeButton);
        var spanVolumeSlider = document.createElement('span');
        spanVolumeSlider.classList.add('volume-slider');
        spanVolumeSlider.classList.add('volume-hidden');
        var spanVolumeSliderTotal = document.createElement('span');
        spanVolumeSliderTotal.classList.add('volume-sliderTotale');
        var volumeInputRange = document.createElement('input');
        volumeInputRange.setAttribute('type', 'range');
        volumeInputRange.setAttribute('min', '0');
        volumeInputRange.setAttribute('max', '100');
        volumeInputRange.classList.add('volume-input-range');
        volumeInputRange.addEventListener("input", function(e){
            let newVolume = parseInt(e.currentTarget.value);
            this.domElement.superPlayer.setVolume(newVolume);
        }.bind(this));
        spanVolumeSliderTotal.appendChild(volumeInputRange);
        spanVolumeSlider.appendChild(spanVolumeSliderTotal);
        spanVolume.appendChild(spanVolumeSlider);


        spanVolume.appendChild(volumeButton);

        divControls2.appendChild(repeatButton);
        divControls2.appendChild(randomButton);
        divControls2.appendChild(spanVolume);

        return divControls2;
    }.bind(this);

    let generateSuperPlayerDOM_Menu = function() {
        var divMenu = document.createElement('div');
        divMenu.classList.add('menu');

        var menuButton = document.createElement('button');
        menuButton.classList.add('menu-button');
        menuButton.addEventListener("click", function (e) {
            var menuPannel = document.querySelector('.audioplayer-mini .menu-pannel');
            let cTarget = e.currentTarget;
            let state = 'is-active';
            if (cTarget.classList.item(1) == null) {
                cTarget.classList.add(state);
            }else{
                cTarget.classList.remove(state)
            }
            if (menuPannel.classList.contains("menu-visible")) {
                menuPannel.classList.remove("menu-visible");
                menuPannel.classList.add("menu-hidden");
            } else {
                menuPannel.classList.remove("menu-hidden");
                menuPannel.classList.add("menu-visible");
            }
        });
        divMenu.appendChild(menuButton);

        return divMenu;
    };

    let generateSuperPlayerDOM_MenuPannel = function() {
        var divMenuPanel = document.createElement('div');
        divMenuPanel.classList.add('menu-pannel');
        divMenuPanel.classList.add('menu-off');

        var repeatButton = document.createElement('button');
        repeatButton.classList.add('repeat-button');
        repeatButton.addEventListener("click", function(e){
            let state = "is-active";
            if (e.currentTarget.classList.item(1) == null) {
                e.currentTarget.classList.add(state);
                console.log("aze");
                if (e.currentTarget.nextSibling.classList.item(1) !== null) {
                    e.currentTarget.nextSibling.classList.remove(state);
                }
            }else{
                e.currentTarget.classList.remove(state);
            }
        });
        // repeatButton.style.visibility = "hidden";
        var randomButton = document.createElement('button');
        randomButton.classList.add('random-button');
        randomButton.addEventListener("click", function(e){
            let state = "is-active";
            if (e.currentTarget.classList.item(1) == null) {
                e.currentTarget.classList.add(state);
                console.log("aze");
                if (e.currentTarget.previousSibling.classList.item(1) !== null) {
                    e.currentTarget.previousSibling.classList.remove(state);
                }
            }else{
                e.currentTarget.classList.remove(state);
            }
        });
        // randomButton.style.visibility = "hidden";
        var volumeButton = document.createElement('button');
        volumeButton.classList.add('volume-button');
        volumeButton.classList.add('volume-moyen2');
        volumeButton.addEventListener('mouseover', function(e){
            var volumePannel = document.querySelector('.audioplayer-mini .controls2 .volume .volume-slider');
            if (volumePannel.classList.contains("volume-visible")) {
                volumePannel.classList.remove("volume-visible");
                volumePannel.classList.add("volume-hidden");
            } else {
                volumePannel.classList.remove("volume-hidden");
                volumePannel.classList.add("volume-visible");
            }
        }, true );
        divMenuPanel.appendChild(repeatButton);
        divMenuPanel.appendChild(randomButton);
        divMenuPanel.appendChild(volumeButton);

        return divMenuPanel;
    };

    let generateSuperPlayerDOM_Playlist = function() {
        var divPlaylist = document.createElement('div');
        divPlaylist.classList.add('playlist-div');

        var playlistButton = document.createElement('button');
        playlistButton.classList.add('playlist-button');
        playlistButton.addEventListener('click', function(e){
            var playlistPannel = document.querySelector('.audioplayer-mini .playlist-pannel');
            let cTarget = e.currentTarget;
            let state = 'is-active';
            if (cTarget.classList.item(1) == null) {
                cTarget.classList.add(state);
            }else{
                cTarget.classList.remove(state)
            }

            if (playlistPannel.classList.contains("playlist-visible")) {
                playlistPannel.classList.remove("playlist-visible");
                playlistPannel.classList.add("playlist-hidden");
            } else {
                playlistPannel.classList.remove("playlist-hidden");
                playlistPannel.classList.add("playlist-visible");
            }
        }, true );

        divPlaylist.appendChild(playlistButton);

        return divPlaylist;
    };

    let generateSuperPlayerDOM_PlaylistPannel = function() {
        var divPlaylistPanel = document.createElement('div');
        divPlaylistPanel.classList.add('playlist-pannel');
        divPlaylistPanel.classList.add('playlist-hidden');

        var listPlaylist = document.createElement('div');
        listPlaylist.classList.add('playlist');

        divPlaylistPanel.appendChild(listPlaylist);

        return divPlaylistPanel;
    };

    constructor(domElement);
}
