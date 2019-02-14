/**
 * Class will do every music based actions
 * @param {ElementNode} domElement - DOM Element on the page
 */
function SuperPlayer(domElement) {
    /**
     * Use to do all operations needed to use the player
     * @namespace private
	 * @param domElement Element DOM correspondant au player
     */
     let constructor = function (domElement) {
 		domElement.superPlayer = this ;  // Permet de récupérer l'objet Player associé à l'élement DOM, donc de parcourir la playlist, etc...
 		this.domElement = domElement ;
        new SuperPlayerDom(this.domElement);
        this.currentTime = 0;
        this.volume = Number(this.domElement.querySelector(".controls2 .volume input[type=range].volume-input-range ").value);
        this.playlist = new Playlist(this);
        this.sound = null;

        this.setListener();
        //Use to apply the right color to the background of the volume input
        // PlayerUtils.createNewEventAndUseOnATarget("input", this.domElement.querySelector(".audioplayer-mini .controls2 .volume input[type=range].volume-input-range"));

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
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ESSAYE AVEC LE addMusicById + soundManager.getSoundById()
        //SINON simuler la reponse de l'API
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        // ###############################################################
        if (soundManager.getSoundById(currentMusic.title + "-" + currentMusic.artistName) !== undefined) {
            this.sound = soundManager.getSoundById(currentMusic.title + "-" + currentMusic.artistName);
            this.sound.setVolume(this.volume);
            //Update the whilePlaying Trigger
            this.sound.play({
                whileplaying: this.drawMusicTime.bind(this)
            });
            this.sound.pause();

        } else {
            this.sound = soundManager.createSound({
                id: currentMusic['title'] + "-" + currentMusic['artistName'], // Id arbitraire
                url: currentMusic['musicPath'],
                whileplaying: this.drawMusicTime.bind(this),
                volume: this.volume,
                onfinish: this.next.bind(this)
            });

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
     * Will draw current time of the current music each second
     * @namespace private
     */
    this.drawMusicTime = function () {
        if (this.sound != null) {
            let currentTime = this.domElement.querySelector(".audioplayer-mini .timer .temps .en-cours");
            let percentile = (this.sound.position/1000) / (this.playlist.getCurrentMusic().duration);
            currentTime.nextSibling.style.setProperty('--pourcent', percentile*100);
            if (!currentTime.classList.contains("spectrumHoverTime"))
                currentTime.innerText = PlayerUtils.milliSecondsToReadableTime(this.sound.position);
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
            this.domElement.querySelector(".audioplayer-mini .visuel .pochette").setAttribute('src',currentMusic.coverPath);
            this.domElement.querySelector(".audioplayer-mini .artiste").innerText = currentMusic.artistName;
            this.domElement.querySelector(".audioplayer-mini .titre").innerText = currentMusic.title;
            this.domElement.querySelector(".audioplayer-mini .timer .temps .en-cours").innerText = "0:00";
            this.domElement.querySelector(".audioplayer-mini .timer .temps .total").innerText = PlayerUtils.secondsToReadableTime(currentMusic.duration);
        }
    };

    /**
     * Call functions of "first" draw when a new music is loaded
     * @namespace private
     */
    this.repaint = function () {
        this.drawMusicData();
        this.checkCookies();
        this.playlist.repaintPlaylist();
    };

    /**
     * Set all listeners of each actions
     * @namespace private
     */
    this.setListener = function () {
        this.domElement.querySelector(".audioplayer-mini .prev").addEventListener("click", this.previous.bind(this));
        this.domElement.querySelector(".audioplayer-mini .next").addEventListener("click", this.next.bind(this));
        this.domElement.querySelector(".audioplayer-mini .play-pause").addEventListener("click", function(e) {
            this.play_pause();
        }.bind(this));

        this.domElement.querySelector(".audioplayer-mini .like-button").addEventListener("click", this.like.bind(this));
        this.domElement.querySelector(".audioplayer-mini .share .share-button").addEventListener("click", this.share.bind(this));

        // this.domElement.querySelector(".audioplayer-mini .controls2 .volume input[type=range].volume-input-range").addEventListener("input", this.targetVolume.bind(this));
        //Use for IE
        // this.domElement.querySelector(".audioplayer-mini .controls2 .volume input[type=range].volume-input-range").addEventListener("change", this.targetVolume.bind(this));

        //Applied a different listener in case of mobile version
        if (PlayerUtils.mobileAndTabletCheck() || PlayerUtils.detectCompactSize()) {
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").addEventListener("click", this.volumeMouseOverCompact.bind(this));
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").addEventListener("click", this.volumeMouseOutCompact.bind(this));
        } else {
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").addEventListener("click", this.mute.bind(this));
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").addEventListener("mouseover", this.volumeMouseOver.bind(this));
        }
    }.bind(this);

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
        let state = "is-active";
        if (this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").classList.contains(state)) {
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").classList.remove(state);
        }else {
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button").classList.add(state);
        }


    };

    /**
     * Will show the pop-up volume on compact/mobile version
     * @namespace private
     */
    this.volumeMouseOverCompact = function () {
        let volumeButton = this.domElement.querySelector(".audioplayer-mini .controls2 .volume");

        if (!volumeButton.classList.contains("volume-timed")) {
            volumeButton.classList.add("is-active");

            //Little timeout to avoid a instant showing and hiding
            setTimeout(function () {
                volumeButton.classList.add("volume-timed");

            }, 200)
        }
    };

    /**
     * Will hide the pop-up volume on compact/mobile version
     * @namespace private
     */
    this.volumeMouseOutCompact = function () {
        let volumeButton = this.domElement.querySelector(".audioplayer-mini .controls2 .volume");

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
                this.domElement.querySelector(".audioplayer-mini .controls .prev").style.visibility = "visible";
                this.domElement.querySelector(".audioplayer-mini .controls .next").style.visibility = "visible";
                this.domElement.querySelector(".audioplayer-mini .controls .volume").style.marginLeft = "0px";
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
            this.domElement.querySelector(".audioplayer-mini .controls .prev").style.visibility = "visible";
            this.domElement.querySelector(".audioplayer-mini .controls .next").style.visibility = "visible";
            this.domElement.querySelector(".audioplayer-mini .controls2 .volume").style.marginLeft = "0px";
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
            this.domElement.querySelector(".like-button").classList.add("is-active");


        } else {
            this.domElement.querySelector(".like-button").classList.remove("is-active");
        }
    };

    constructor(domElement);
};

/**
 * Set the new volume
 * @namespace Player
 * @param {int} newVolume
 */
SuperPlayer.prototype.setVolume = function (newVolume) {
    this.volume = newVolume;
    if (this.sound !== null) {
        this.sound.setVolume(newVolume);
        let volume = this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button");
        let volume2 = this.domElement.querySelector(".audioplayer-mini .menu-pannel .volume-button");
        if (newVolume === 0) {
            if (volume.classList.item(1) !== null) {
                volume.classList.replace(volume.classList.item(1), "volume-off");
            }
            if (volume2.classList.item(1) !== null) {
                volume2.classList.replace(volume2.classList.item(1), "volume-off");
            }
        }else if (newVolume>0 && newVolume<33){
            if (volume.classList.item(1) !== null) {
                volume.classList.replace(volume.classList.item(1), "volume-on");
            }
            if (volume2.classList.item(1) !== null) {
                volume2.classList.replace(volume2.classList.item(1), "volume-on");
            }
        }else if(newVolume>33 && newVolume<66){
            if (volume.classList.item(1) !== null) {
                volume.classList.replace(volume.classList.item(1), "volume-moyen2");
            }
            if (volume2.classList.item(1) !== null) {
                volume2.classList.replace(volume2.classList.item(1), "volume-moyen2");
            }
        }else if(newVolume>66){
            if (volume.classList.item(1) !== null) {
                volume.classList.replace(volume.classList.item(1), "volume-moyen3");
            }
            if (volume2.classList.item(1) !== null) {
                volume2.classList.replace(volume2.classList.item(1), "volume-moyen3");
            }
        }
    }
};


/**
 * Toggle the sound or not
 * @namespace Player
 */
SuperPlayer.prototype.mute = function () {
    let volume = this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button");
    if (volume.classList.item(1) !== null) {
        if (volume.classList.item(1) != "volume-off") {
            volume.classList.replace(volume.classList.item(1), "volume-off");
            if (this.sound !== null){
                this.sound.mute();
            }
        }else {
            this.sound.unmute();
            let lastVolume = this.domElement.querySelector(".audioplayer-mini .controls2 .volume-slider .volume-sliderTotale .volume-input-range").value;
            this.setVolume(lastVolume);
        }
    }
};


/**
 * Return if the player add the mute button enabled
 * @namespace Player
 * @returns {boolean} - if the player if muted
 */
SuperPlayer.prototype.playerIsMute = function () {
    let volume = this.domElement.querySelector(".audioplayer-mini .controls2 .volume .volume-button");
    return volume.classList.contains('volume-off');
};

/**
 * Will add a like to the database and add 1 to the number of like show
 * If a like button already been pressed, remove the like
 * @namespace Player
 */
SuperPlayer.prototype.like = function () {
    let currentMusic = this.playlist.getCurrentMusic();

    if (PlayerUtils.getCookie("song-" + currentMusic.id + "-alreadyLike") === "") {
        Connexion.addLike(currentMusic.id, console.log);
        this.domElement.querySelector(".like-button").classList.add("is-active");


        let likeNumber = this.domElement.querySelector(".like-button");
        likeNumber.innerText = Number(likeNumber.innerText) + 1;
        currentMusic.numberLike++;

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyLike", "true", 99);
    } else {
        Connexion.removeLike(currentMusic.id, console.log);
        this.domElement.querySelector(".like-button").classList.remove("is-active");

        let likeNumber = this.domElement.querySelector(".like-button");
        likeNumber.innerText = Number(likeNumber.innerText) - 1;
        currentMusic.numberLike--;

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyLike", "", 99);
    }
};


/**
 * Will add a comment to the database, the current screen and add 1 for the number of comments
 * @namespace Player
 */
SuperPlayer.prototype.addComment = function () {
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
SuperPlayer.prototype.share = function () {
    var shareButton = this.domElement.querySelector(".audioplayer-mini .share .share-button");
    if (shareButton.classList.item(1) == null) {
        shareButton.classList.add("is-active");
    }
    var modal = document.querySelector('.modal');
    var close = document.querySelector(".modal .close");
    var inputShare = document.querySelector(".modal .share-body input[type=text].share-input-text");
    var btnCopy = document.querySelector(".modal .copy-button");
    modal.style.display = "block";

    // Close the modal with the close button
    close.onclick = function () {
        shareButton.classList.remove(shareButton.classList.item(1));
        modal.style.display = "none";
        inputShare.value = "";
    };

    // Close the modal by clicking outside it
    window.onclick = function (event) {
        if (event.target === modal) {
            shareButton.classList.remove(shareButton.classList.item(1));
            modal.style.display = "none";
            inputShare.value = "";
        }
    };

    // Copy the select
    btnCopy.onclick = function () {
        inputShare.select();
        document.execCommand("copy");
    };

    let currentMusic = this.playlist.getCurrentMusic();
    if (currentMusic === null) {
        currentMusic = "test";
    }
    inputShare.value = ('<iframe src="http://localhost:3000/music?idMusic=' + currentMusic.id + '" width="100%" height="230" frameborder="no" scrolling="no"></iframe>');
};

/**
 * Set the new position of the music and change the CSS of the waveform's bars
 * @namespace Player
 * @param newPosition {int} the position of the cursor when it's click
 */
SuperPlayer.prototype.goTo = function (newPosition) {
    if (this.sound != null) {
        this.currentTime = newPosition;
        this.sound.setPosition(newPosition*1000);
        if (this.sound.paused){
            this.play_pause();
        }
    }
};

/**
 *  Use to set on play or on pause state the current music, if no current music is null, create it and launch it if
 *  possible
 *  @namespace Player
 */
SuperPlayer.prototype.play_pause = function () {
    let currentMusic = this.playlist.getCurrentMusic();

    //If not undefined
    if (currentMusic != null) {
        let playButton = this.domElement.querySelector(".audioplayer-mini .play-pause");
        //If don't have any current sound in play
        if (this.sound == null) {

            //Create a new Sound
            this.loadMusic();

            this.sound.play();
            playButton.classList.remove("play");
            playButton.classList.add("pause");
        }
        //If a Sound is already set
        else {
            //If it loaded and played or paused
            if (this.sound.playState) {
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
SuperPlayer.prototype.next = function () {
    if (this.sound != null) {
        this.sound.stop();
        this.sound.unload();
        this.sound = null;
    }
    this.domElement.querySelector(".audioplayer-mini .timer .temps .progress-bar").style.setProperty('--pourcent', 0);
    this.playlist.next();
    this.repaint();
    this.play_pause();
};

/**
 * Override the Playlist function to add the SoundManager's functions
 * @namespace Player
 */
SuperPlayer.prototype.previous = function () {
    if (this.sound != null) {
        this.sound.stop();
        this.sound.unload();
        this.sound = null;
    }
    this.domElement.querySelector(".audioplayer-mini .timer .temps .progress-bar").style.setProperty('--pourcent', 0);
    this.playlist.previous();
    this.repaint();
    this.play_pause();
};


/**
 * Will add 1 to the number of view of the music if the local cookie allows it
 * @namespace Player
 */
SuperPlayer.prototype.addView = function () {
    let currentMusic = this.playlist.getCurrentMusic();

    if (PlayerUtils.getCookie("song-" + currentMusic.id + "-alreadyView") === "") {
        Connexion.addNumberOfView(currentMusic.id, console.log);

        currentMusic.numberView++;
        this.repaint();

        PlayerUtils.setCookie("song-" + currentMusic.id + "-alreadyView", "true", 1);
    }
};
