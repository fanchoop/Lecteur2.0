/**
 * Class will do every music based actions
 * @param {ElementNode} domElement - DOM Element on the page
 */
function Player(domElement) {
    /**
     * Use to do all operations needed to use the player
     * @namespace private
	 * @param domElement Element DOM correspondant au player
     */
    let constructor = function (domElement) {
		domElement.player = this ;  // Permet de récupérer l'objet Player associé à l'élement DOM, donc de parcourir la playlist, etc...
		this.domElement = domElement ;
        this.currentTime = 0;
        this.volume = Number(this.domElement.querySelector(".controls .volume input[type=range].volume-input-range ").value);
        this.playlist = new Playlist(this);
        this.sound = null;


        //Check if some information is present into the url
        let idMusicToLoad = Connexion.getIdMusicParam();
        let idPlaylistToLoad = Connexion.getIdPlaylistParam();

        if (idPlaylistToLoad !== 0 && idMusicToLoad !== 0) {
            this.addPlaylist(idPlaylistToLoad, idMusicToLoad);
        } else if (idPlaylistToLoad !== 0) {
            this.addPlaylist(idPlaylistToLoad, -1); // -1 is same way to put nothing
        } else if (idMusicToLoad !== 0) {
            this.addMusicById(idMusicToLoad);
        }

        this.setListener();

        //Use to apply the right color to the background of the volume input
        PlayerUtils.createNewEventAndUseOnATarget("input", this.domElement.querySelector(".controls .volume input[type=range].volume-input-range"));


    }.bind(this);

    /**
     * Create a SoundManagerSound with the currentMusic in the playlist and reload the page
     * @namespace private
     */
    this.loadMusic = function () {
        if (this.sound !== null) {
            this.sound.stop();
            this.sound.unload();

        }

        let currentMusic = this.playlist.getCurrentMusic();
        if (soundManager.getSoundById(currentMusic.title + "-" + currentMusic.artistName) !== undefined) {
            this.sound = soundManager.getSoundById(currentMusic.title + "-" + currentMusic.artistName);
            this.sound.setVolume(this.volume);
        } else {
            this.sound = soundManager.createSound({
                id: currentMusic['title'] + "-" + currentMusic['artistName'], // Id arbitraire
                url: currentMusic['musicPath'],
                whileplaying: this.drawMusicTime.bind(this),
                volume: this.volume,
                onfinish: this.next.bind(this)
            });
            // //To be used by SuperPlayer
            // let superPlayer = document.querySelector("div.audioplayer-mini");
            // if (typeof superPlayer !== "undefined") {
            //     this.sound.coverPath = currentMusic['coverPath'];
            //     this.sound.title = currentMusic['title'];
            //     this.sound.artistName = currentMusic['artistName'];
            //     this.sound.duration = currentMusic['duration'];
            // }

        }

        if (this.sound.muted) {
            this.mute();
        }

        this.sound.play();
        this.sound.pause();
        this.repaint();
    }.bind(this);


    /** Private functions */

    /**
     * Will colorize the current point of playing
     * @namespace private
     */
    this.colorWaveToCurrentPos = function () {
        let hasBeenHoverBack = false;

        let waveform = this.domElement.querySelectorAll(".waveform .sprectrumContainer");
        let barPosition = Math.ceil(this.sound.position / ( this.playlist.getCurrentMusic().duration * 1000 ) * waveform[0].childElementCount);
        let bar_up;
        let bar_bottom;

        for (let position = 0; position <= barPosition; position++) {
            bar_up = waveform[0].childNodes[position];
            bar_bottom = waveform[1].childNodes[position];

            //Check if the new position get the "hover-front" class, remove it
            if (bar_up.classList.contains("hover-front") || bar_bottom.classList.contains("hover-front")) {
                bar_up.classList.remove("hover-front");
                bar_bottom.classList.remove("hover-front");
            }

            bar_up.classList.add("played");
            bar_bottom.classList.add("played");


            //Check if a "hover-back" class is set
            if (bar_up.classList.contains("hover-back") || bar_bottom.classList.contains("hover-back"))
                hasBeenHoverBack = true;

            //If one of the bar get the "hover-back" class, add it to all next bars
            if (hasBeenHoverBack)
                if (!bar_up.classList.contains("hover-front") && !bar_bottom.classList.contains("hover-front")) {
                    bar_up.classList.add("hover-back");
                    bar_bottom.classList.add("hover-back");
                }
        }
    };

    /**
     * Will colorize the current point of playing of the hovered point
     * @namespace private
     * @param pos {int} number of the bar hovered
     */

    this.colorWaveToHoverPos = function (pos) {
        let players = document.querySelectorAll("article[id*=player]");
        let currentPlayer = this.domElement.player;
        for (var i = 0; i < players.length; i++) {
            if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                // players[i].querySelector(".audioplayer").player.clearColorWave();
                let waveform = players[i].querySelectorAll(".waveform .sprectrumContainer");
                let waveformUp = waveform[0];
                let waveformDown = waveform[1];
                let barPosition;
                if (this.sound == null) {
                    barPosition = 0;
                } else {
                    barPosition = Math.ceil(this.sound.position / ( this.playlist.getCurrentMusic().duration * 1000 ) * waveform[0].childElementCount);
                }
                if (barPosition <= pos) {
                    for (let position = barPosition + 1; position <= pos; position++) {
                        waveformUp.childNodes[position].classList.add("hover-front");
                        waveformDown.childNodes[position].classList.add("hover-front");
                    }
                } else {
                    for (let position = pos; position <= barPosition; position++) {
                        waveformUp.childNodes[position].classList.add("hover-back");
                        waveformDown.childNodes[position].classList.add("hover-back");
                    }
                }
            }
        }
    };

    /**
     * Will remove the class "played" and "hover" of all bars of the waveform
     * @namespace private
     */
    this.clearColorWave = function () {
        let barsList = this.domElement.querySelectorAll(".audioplayer .bar-up ,.audioplayer .bar-down");
        if (barsList.length !== 0) {
            for (var index = 0; index < barsList.length; index++) {
                barsList[index].classList.remove("played");
                barsList[index].classList.remove("played-flash");
                barsList[index].classList.remove("hover-front");
                barsList[index].classList.remove("hover-back");
            }

        }

    };

    /**
     * Will remove the class "hover" of all bars of the waveform
     * @namespace private
     */
    this.clearColorHoverWave = function () {
        let barsList = this.domElement.querySelectorAll(".bar-up ,.audioplayer .bar-down");
        if (barsList.length !== 0) {
            for (var index = 0; index < barsList.length; index++) {

                barsList[index].classList.remove("hover-front");
                barsList[index].classList.remove("hover-back");
            }

        }
    };

    /**
     * Will remove the class "spectrumHoverTime" and clear the time
     * @namespace private
     */
    this.clearHoverTime = function () {
        let currentTime = this.domElement.querySelector(".en-cours");
        currentTime.classList.remove("spectrumHoverTime");
        currentTime.innerText = PlayerUtils.milliSecondsToReadableTime(this.sound.position);
    };


    /**
     * Show the current time of the music according to the hovered position of the spectrum and add class "spectrumHoverTime"
     * @namespace private
     * @param position
     */
    this.drawHoverTime = function (position) {
        let currentTime = this.domElement.querySelector(".en-cours");
        let nbBarSpectrum = this.domElement.querySelectorAll(".waveform .sprectrumContainer")[0].childElementCount - 1;

        if (!currentTime.classList.contains("spectrumHoverTime")) {
            let time = position / nbBarSpectrum * ( this.playlist.getCurrentMusic().duration * 1000 );
            currentTime.innerText = PlayerUtils.milliSecondsToReadableTime(time);
            currentTime.classList.add("spectrumHoverTime");

        }
    };


    this.addWaveformListener = function (){
        var waveformElement = this.domElement.querySelector(".audioplayer .player .waveform");

        waveformElement.addEventListener("mousemove", function(e){
            let rect = e.currentTarget.getBoundingClientRect();
            let posX = e.clientX - rect.left;
            let barPosition = parseInt(posX/4);

            var query = ".audioplayer .player .waveform .bar-up[data_position='" + barPosition + "']";
            var target = this.domElement.querySelector(query);
            if (target !== null) {
                let players = document.querySelectorAll("article[id*=player]");
                let currentPlayer = this.domElement.player;
                for (var i = 0; i < players.length; i++) {
                    if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                        if (target.attributes.hasOwnProperty("data_position")) {
                            players[i].querySelector(".audioplayer").player.clearColorHoverWave();
                            players[i].querySelector(".audioplayer").player.clearHoverTime();
                            players[i].querySelector(".audioplayer").player.colorWaveToHoverPos(Number(target.attributes.data_position.value));
                            players[i].querySelector(".audioplayer").player.drawHoverTime(Number(target.attributes.data_position.value))
                        }
                    }
                }
            }
        }.bind(this));

        waveformElement.addEventListener("click", function(e){
            let rect = e.currentTarget.getBoundingClientRect();
            let posX = e.clientX - rect.left;
            let barPosition = parseInt(posX/4);

            var query = ".audioplayer .player .waveform .bar-up[data_position='" + barPosition + "']";
            var target = this.domElement.querySelector(query);
            if (target !== null) {

                if (target.attributes.hasOwnProperty("data_position")){
                    this.goTo(Number(target.attributes.data_position.value));
                }
            }
        }.bind(this));

        waveformElement.addEventListener("mouseleave", function(e){
            if (e.target == e.currentTarget){
                let players = document.querySelectorAll("article[id*=player]");
                let currentPlayer = this.domElement.player;
                for (var i = 0; i < players.length; i++) {
                    if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                        players[i].querySelector(".audioplayer").player.clearColorHoverWave();
                        players[i].querySelector(".audioplayer").player.clearHoverTime();
                    }
                }
            }
        }.bind(this));
    };


    /**
     * Will draw the waveform at this position
     * @namespace private
     */
    this.drawSpectrum = function () {
        this.clearColorWave();

        if (this.sound != null) {
            let barPositionPercentile = this.sound.position / ( this.playlist.getCurrentMusic().duration * 1000 );

            createWaveForm(this, this.playlist.getCurrentMusic().listPoints, barPositionPercentile);
        } else {
            createWaveForm(this, this.playlist.getCurrentMusic().listPoints);
        }

        //ANCIEN CODE (Listener sur chaque bar du spectre)
        //Add event to each bar of the spectrum
    //     var barsList = this.domElement.querySelectorAll(".bar-up , .audioplayer .bar-down");
    //     for (var index = 0; index < barsList.length; index++) {
    //         barsList[index].addEventListener("click", function (evt) {
    //             this.clearColorWave();
    //             if (evt.target.attributes.hasOwnProperty("data_position"))
    //                 this.goTo(Number(evt.target.attributes.data_position.value));
    //         }.bind(this));
    //         barsList[index].addEventListener("mouseover", function (evt) {
    //             if (evt.target.attributes.hasOwnProperty("data_position")) {
    //                 this.colorWaveToHoverPos(Number(evt.target.attributes.data_position.value));
    //                 this.drawHoverTime(Number(evt.target.attributes.data_position.value))
    //             }
    //         }.bind(this));
    //         barsList[index].addEventListener("mouseout", function () {
    //             this.clearColorHoverWave();
    //             this.clearHoverTime();
    //         }.bind(this));
    //     }
        this.addWaveformListener();
    };

    /**
     * Will draw current time of the current music each second
     * @namespace private
     */
    this.drawMusicTime = function () {
        if (this.sound != null) {
            let players = document.querySelectorAll("article[id*=player]");
            let currentPlayer = this.domElement.player;
            for (var i = 0; i < players.length; i++) {
                if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                    let currentTime = players[i].querySelector(".en-cours");
                    if (!currentTime.classList.contains("spectrumHoverTime")){
                        currentTime.innerText = PlayerUtils.milliSecondsToReadableTime(this.sound.position);
                    }
                    players[i].querySelector(".audioplayer").player.colorWaveToCurrentPos();
                }
            }

        }
    };

    /**
     * Draw all information about the music, called when the music is loaded
     * @namespace private
     */
    this.drawMusicData = function () {
        let currentMusic = this.playlist.getCurrentMusic();
        if (currentMusic != null) {
            //Add an escape double quote to allow name with quote
            this.domElement.querySelector(".visuel").style.background = "url(\"" + currentMusic.coverPath + "\")";
            this.domElement.querySelector(".artiste").innerText = currentMusic.artistName;
            this.domElement.querySelector(".titre").innerText = currentMusic.title;
            this.domElement.querySelector(".total").innerText = PlayerUtils.secondsToReadableTime(currentMusic.duration);
            this.domElement.querySelector(".nb-lectures").innerText = currentMusic.numberView;
            this.domElement.querySelector(".nb-commentaires").innerText = currentMusic.numberComment;
            this.domElement.querySelector(".like").innerText = currentMusic.numberLike;
        }
    };

    /**
     * Call functions of "first" draw when a new music is loaded
     * @namespace private
     */
    this.repaint = function () {
        this.drawSpectrum();
        this.drawMusicData();
        this.checkCookies();
        this.playlist.repaintPlaylist();
    };

    /**
     * Set all listeners of each actions
     * @namespace private
     */
    this.setListener = function () {

        window.addEventListener("resize", this.drawSpectrum.bind(this));

        this.domElement.querySelector(".prev").addEventListener("click", this.previous.bind(this));
        this.domElement.querySelector(".next").addEventListener("click", this.next.bind(this));
        this.domElement.querySelector(".play-pause").addEventListener("click", function(e) {
            this.play_pause();
        }.bind(this));
        this.domElement.querySelector(".like").addEventListener("click", this.like.bind(this));
        this.domElement.querySelector(".share").addEventListener("click", this.share.bind(this));
        this.domElement.querySelector(".controls .volume input[type=range].volume-input-range").addEventListener("input", this.targetVolume.bind(this));
        //Use for IE
        this.domElement.querySelector(".controls .volume input[type=range].volume-input-range").addEventListener("change", this.targetVolume.bind(this));

        //Applied a different listener in case of mobile version
        if (PlayerUtils.mobileAndTabletCheck() || PlayerUtils.detectCompactSize()) {
            this.domElement.querySelector(".controls .volume .volume_button").addEventListener("click", this.volumeMouseOverCompact.bind(this));
            this.domElement.querySelector(".controls .volume .volume_button").addEventListener("click", this.volumeMouseOutCompact.bind(this));
        } else {
            this.domElement.querySelector(".controls .volume .volume_button").addEventListener("click", this.mute.bind(this));
            this.domElement.querySelector(".controls .volume").addEventListener("mouseover", this.volumeMouseOver.bind(this));
            this.domElement.querySelector(".controls .volume").addEventListener("mouseout", this.volumeMouseOut.bind(this));
        }
    };

    /**
     * Set the position of the playlist to the given position and reload the right music
     * @namespace private
     * @param position
     */
    this.setPosition = function (position) {
        this.playlist.setCurrentPosition(position);
        this.loadMusic();
    };

    /**
     * Will show the pop-up volume
     * @namespace private
     */
    this.volumeMouseOver = function () {
        this.domElement.querySelector(".controls .volume").classList.add("is-active");

    };

    /**
     * Will show the pop-up volume on compact/mobile version
     * @namespace private
     */
    this.volumeMouseOverCompact = function () {
        let volumeButton = this.domElement.querySelector(".controls .volume");

        if (!volumeButton.classList.contains("volume-timed")) {
            volumeButton.classList.add("is-active");

            //Little timeout to avoid a instant showing and hiding
            setTimeout(function () {
                volumeButton.classList.add("volume-timed");

            }, 200)
        }
    };

    /**
     * Will hide the pop-up volume
     * @namespace private
     */
    this.volumeMouseOut = function () {
        this.domElement.querySelector(".controls .volume").classList.remove("is-active");
    };

    /**
     * Will hide the pop-up volume on compact/mobile version
     * @namespace private
     */
    this.volumeMouseOutCompact = function () {
        let volumeButton = this.domElement.querySelector(".controls .volume");

        if (volumeButton.classList.contains("volume-timed")) {
            volumeButton.classList.remove("is-active");
            //Use to avoid a trigger of the two events at the same time
            setTimeout(function () {
                volumeButton.classList.remove("volume-timed");
            }, 200)
        }
    };


    /**
     * Modify the value of the volume bar and the volume of the music
     * @namespace private
     * @param e {event}
     */
    this.targetVolume = function (e) {
        //The target should be the volume bar
        let min = e.target.min,
            max = e.target.max,
            val = e.target.value;

        let value = (val - min) * 100 / (max - min);
        e.target.style.backgroundSize = value + '% 100%';

        if (this.sound != null) {
            this.setVolume(value);
        }
    };

    /**
     * Go check into the database if a music match with the id, add the music and if this is the first, draw information about this music
     * @namespace private
     * @param idMusic {int} - id of the wanted music
     */
    this.addMusicById = function (idMusic) {
        let firstMusic = this.playlist.getCurrentMusic() == null;

        Connexion.getMusicById(idMusic, function (music) {
            music = new Music(JSON.parse(music));

            this.playlist.addMusic(music);
            if (firstMusic) {
                this.loadMusic();
            } else {
                //Other case, add the visibility of the "previous" and "next" buttons and put the "volume" button at the right place
                this.domElement.querySelector(".controls .prev").style.visibility = "visible";
                this.domElement.querySelector(".controls .next").style.visibility = "visible";
                this.domElement.querySelector(".controls .volume").style.marginLeft = "0px";
            }

            this.checkCookies();

        }.bind(this));
    };

    /**
     * Will add a Music object to the player and playlist
     * @namespace private
     * @param music {Music} - JSON string which represent a Music Object to add
     */
    this.addMusicObject = function (music) {
        let firstMusic = this.playlist.getCurrentMusic() === null;

        this.playlist.addMusic(music);
        if (firstMusic) {
            this.loadMusic();
        } else {
            //Other case, add the visibility of the "previous" and "next" buttons and put the "volume" button at the right place
            this.domElement.querySelector(".controls .prev").style.visibility = "visible";
            this.domElement.querySelector(".controls .next").style.visibility = "visible";
            this.domElement.querySelector(".controls .volume").style.marginLeft = "0px";
        }
    };


    /**
     * Go check into the database to get all music of the wanted playlist and erase the older playlist/music in play
     * @namespace private
     * @param idPlaylistToAdd {int} - id of the playlist into the database
     * @param currentMusicId {int} - if present set the current Music to this one
     */
    this.addPlaylist = function (idPlaylistToAdd, currentMusicId) {
        //Set a default parameter which work with IE11
        currentMusicId = currentMusicId || null;

        Connexion.getPlaylistById(idPlaylistToAdd, function (newPlaylist) {
            if (newPlaylist !== null && newPlaylist !== "[]") {
                this.playlist = new Playlist();
                newPlaylist = JSON.parse(newPlaylist);
                //Position = the given position of the music into the playlist ( {"1" : musicOne, "2" : musicTwo})
                for (let position in newPlaylist) {
                    if (newPlaylist.hasOwnProperty(position)) {

                        let music = new Music(newPlaylist[position]);
                        this.addMusicObject(music);

                        if (music.id === currentMusicId) {
                            this.setPosition(Number(position));
                        }
                    }
                }

                this.checkCookies();
            }

        }.bind(this));

    };

    /**
     * Check all the cookie and apply the correct modification to the player
     * @namespace private
     */
    this.checkCookies = function () {
        let currentMusic = this.playlist.getCurrentMusic();

        if (PlayerUtils.getCookie("song-" + currentMusic.id + "-alreadyLike") !== "") {
            this.domElement.querySelector(".like").classList.add("is-active");


        } else {
            this.domElement.querySelector(".like").classList.remove("is-active");
        }
    };

    constructor(domElement);

}
/**
 * Set the new volume
 * @namespace Player
 * @param {int} newVolume
 */
Player.prototype.setVolume = function (newVolume) {
    this.volume = newVolume;
    if (this.sound !== null) {
        let players = document.querySelectorAll("article[id*=player]");
        let currentPlayer = this.domElement.player;
        for (var i = 0; i < players.length; i++) {
            if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                players[i].querySelector(".audioplayer").player.sound.setVolume(newVolume);
                let volume = players[i].querySelector(".audioplayer .controls .volume .volume_button");
                players[i].querySelector(".audioplayer .controls .volume .volume-input-range").value = newVolume;
                players[i].querySelector(".audioplayer .controls .volume .volume-input-range").style.backgroundSize = newVolume + '% 100%';
                if (newVolume === 0) {
                    if (volume.classList.item(1) !== null) {
                        volume.classList.replace(volume.classList.item(1), "volume-off");
                    }
                }else if (newVolume>0 && newVolume<33){
                    if (volume.classList.item(1) !== null) {
                        volume.classList.replace(volume.classList.item(1), "volume-on");
                    }
                }else if(newVolume>33 && newVolume<66){
                    if (volume.classList.item(1) !== null) {
                        volume.classList.replace(volume.classList.item(1), "volume-moyen2");
                    }
                }else if(newVolume>66){
                    if (volume.classList.item(1) !== null) {
                        volume.classList.replace(volume.classList.item(1), "volume-moyen3");
                    }
                }



            }
        }
    }
};


/**
 * Toggle the sound or not
 * @namespace Player
 */
Player.prototype.mute = function () {
    let volume = this.domElement.querySelector(".controls .volume .volume_button");
    if (volume.classList.item(1) !== null) {
        if (volume.classList.item(1) != "volume-off") {
            volume.classList.replace(volume.classList.item(1), "volume-off");
            if (this.sound !== null){
                this.sound.mute();
            }
        }else {
            this.sound.unmute();
            let lastVolume = this.domElement.querySelector(".audioplayer .player .controls .volume_slider .volume_sliderTotale .volume-input-range").value;
            this.setVolume(lastVolume);
        }
    }
};


/**
 * Return if the player add the mute button enabled
 * @namespace Player
 * @returns {boolean} - if the player if muted
 */
Player.prototype.playerIsMute = function () {
    let volume = this.domElement.querySelector(".controls .volume .volume_button");
    return volume.classList.contains('volume-off');
};

/**
 * Will add a like to the database and add 1 to the number of like show
 * If a like button already been pressed, remove the like
 * @namespace Player
 */
Player.prototype.like = function () {
    let currentMusic = this.playlist.getCurrentMusic();

    if (PlayerUtils.getCookie("song-" + currentMusic.id + "-alreadyLike") === "") {
        Connexion.addLike(currentMusic.id, console.log);
        this.domElement.querySelector(".like").classList.add("ilikeit");


        let likeNumber = this.domElement.querySelector(".like");
        likeNumber.innerText = Number(likeNumber.innerText) + 1;
        currentMusic.numberLike++;

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyLike", "true", 99);
    } else {
        Connexion.removeLike(currentMusic.id, console.log);
        this.domElement.querySelector(".like").classList.remove("ilikeit");

        let likeNumber = this.domElement.querySelector(".like");
        likeNumber.innerText = Number(likeNumber.innerText) - 1;
        currentMusic.numberLike--;

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyLike", "", 99);
    }
};


/**
 * Will add a comment to the database, the current screen and add 1 for the number of comments
 * @namespace Player
 */
Player.prototype.addComment = function () {
    //TODO faire une vraie action
    Connexion.requestPost("/fasma/addLikeComment", {
        id: this.playlist.getCurrentMusic().id,
        comment: "test comment"
    }, console.log);
    this.drawMusicData();
};

/**
 * Will create and give an embed version of the player
 * @namespace Player
 */
Player.prototype.share = function () {
    var modal = document.querySelector('.modal');
    var close = document.querySelector(".modal .close");
    var inputShare = document.querySelector(".modal .share-body input[type=text].share-input-text");
    var btnCopy = document.querySelector(".modal .copy-button");
    modal.style.display = "block";

    // Close the modal with the close button
    close.onclick = function () {
        modal.style.display = "none";
        inputShare.value = "";
    };

    // Close the modal by clicking outside it
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            inputShare.value = "";
            event.stopPropagation();
        }
    };

    // Copy the select
    btnCopy.onclick = function () {
        inputShare.select();
        document.execCommand("copy");
    };

    let currentMusic = this.playlist.getCurrentMusic();

    inputShare.value = ('<iframe src="http://localhost:3000/music?idMusic=' + currentMusic.id + '" width="100%" height="230" frameborder="no" scrolling="no"></iframe>');
};

/**
 * Set the new position of the music and change the CSS of the waveform's bars
 * @namespace Player
 * @param newPosition {int} the position of the cursor when it's click
 */
Player.prototype.goTo = function (newPosition) {
    if (this.sound != null) {
        let players = document.querySelectorAll("article[id*=player]");
        let currentPlayer = this.domElement.player;
        for (var i = 0; i < players.length; i++) {
            if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
                if (players[i].querySelector(".audioplayer").player.sound != null) {
                    let percentile = (newPosition / players[i].querySelector(".waveform .sprectrumContainer").childElementCount);
                    let newTime = percentile * ( players[i].querySelector(".audioplayer").player.playlist.getCurrentMusic().duration * 1000 );
                    players[i].querySelector(".audioplayer").player.currentTime = newTime / 1000;
                    players[i].querySelector(".audioplayer").player.sound.setPosition(newTime);
                    players[i].querySelector(".audioplayer").player.clearColorWave();
                    players[i].querySelector(".audioplayer").player.colorWaveToCurrentPos();
                    if (players[i].querySelector(".audioplayer").player.sound.paused)
                    players[i].querySelector(".audioplayer").player.play_pause();

                }
            }
        }
    }
};

/**
 *  Use to set on play or on pause state the current music, if no current music is null, create it and launch it if
 *  possible
 *  @namespace Player
 */
Player.prototype.play_pause = function () {
    let currentMusic = this.playlist.getCurrentMusic();
    let players = document.querySelectorAll("article[id*=player]");
    let currentPlayer = this.domElement.player;
    for (var i = 0; i < players.length; i++) {
        if (players[i].querySelector(".audioplayer").player.sound.id == currentPlayer.sound.id) {
            if (players[i].querySelector(".audioplayer") !== this.domElement) {
                let playButton = players[i].querySelector(".audioplayer").querySelector(".play-pause");
                let soundState = "play";
                if (playButton.classList.item(1) == soundState) {
                        playButton.classList.replace(playButton.classList.item(1), "pause");
                }else {
                    playButton.classList.replace(playButton.classList.item(1), "play");
                }
            }
        }
    }
    //CHECK if a superPlayer is on the page
    // let superPlayer = document.querySelector("div.audioplayer-mini");
    // if (typeof superPlayer !== "undefined") {
    //     //getThe instance of the superPlayer
    //     superPlayer = superPlayer.superPlayer;
    //     //chek if is only one music or a playlist
    //     if (this.playlist.musicList.length == 1) {
    //         //Do for one music
    //         if (superPlayer.isAPlaylist == true) {
    //             superPlayer.playlist = new Playlist(superPlayer);
    //             superPlayer.isAPlaylist = false;
    //         }
    //         let soundIsUsed = false;
    //         for (var i = 0; i < superPlayer.playlist.musicList.length; i++) {
    //             if (superPlayer.playlist.musicList[i] == this.sound) {
    //                 soundIsUsed = true
    //             }
    //         }
    //         if (!soundIsUsed) {
    //             superPlayer.addMusicByInstance(this.sound);
    //         }
    //
    //     }else if (this.playlist.musicList.length > 1) {
    //         //Do for a playlist
    //         superPlayer.playlist = this.playlist;
    //         superPlayer.repaint();
    //         superPlayer.isAPlaylist = true;
    //     }else{
    //         console.error("No Music on this Player");
    //     }
    // }
    //If not undefined
    if (currentMusic != null) {
        let playButton = this.domElement.querySelector(".play-pause");
        //If don't have any current sound in play
        if (this.sound == null) {
            //Reset the waveform color in case of a new music
            this.clearColorWave();

            //Create a new Sound
            this.loadMusic();

            this.sound.play();
            playButton.classList.remove("play");
            playButton.classList.add("pause");
        }
        //If a Sound is already set
        else {
            //If it loaded and played or paused
            console.log(this.sound.playState);
            if (this.sound.playState) {
                if (this.sound.paused) {
                    this.sound.resume();
                    playButton.classList.replace("play", "pause");

                }//If it's played
                else {
                    this.sound.pause();
                    playButton.classList.replace("pause", "play");
                }
            }else{
                this.loadMusic();
                if (this.sound.paused) {
                    this.sound.resume();
                    playButton.classList.remove("play");
                    playButton.classList.add("pause");

                }//If it's played
                else {
                    this.sound.pause();
                    playButton.classList.remove("pause");
                    playButton.classList.add("play");
                }
            }
        }

        if (this.playerIsMute()) {
            this.sound.mute();
        } else {
            this.sound.unmute();
        }

        //Add 1 to the value of view if isn't done
        this.addView();

    } else {
        console.error("No music into the playlist !");
    }

};

/**
 * Override the Playlist function to add the SoundManager's functions
 * @namespace Player
 */
Player.prototype.next = function () {
    if (this.sound != null) {
        this.sound.stop();
        this.sound.unload();
        this.sound = null;
    }

    this.playlist.next();
    this.repaint();
    this.play_pause();
};

/**
 * Override the Playlist function to add the SoundManager's functions
 * @namespace Player
 */
Player.prototype.previous = function () {
    if (this.sound != null) {
        this.sound.stop();
        this.sound.unload();
        this.sound = null;
    }

    this.playlist.previous();
    this.repaint();
    this.play_pause();
};


/**
 * Will add 1 to the number of view of the music if the local cookie allows it
 * @namespace Player
 */
Player.prototype.addView = function () {
    let currentMusic = this.playlist.getCurrentMusic();

    if (PlayerUtils.getCookie("song-" + currentMusic.id + "-alreadyView") === "") {
        Connexion.addNumberOfView(currentMusic.id, console.log);

        currentMusic.numberView++;
        this.repaint();

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyView", "true", 1);
    }
};
