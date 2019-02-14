/**
 * Class used to control the playlist and the music
 * @param {Player} player - Reference to the parent Player object
 */
function Playlist(player) {
	this.player = player ;
    this.musicList = [];
    this.currentPosition = 0;
    this.currentMusic = null;

}

/**
 * Put the new position of the current music in the playlist
 * @param {int} newPosition - The new position of the current music
 */
Playlist.prototype.setCurrentPosition = function (newPosition) {

    if (newPosition < this.musicList.length && newPosition >= 0) {
        this.currentPosition = newPosition;
        this.currentMusic = this.musicList[newPosition];
    }
};

/**
 * Get the current position of the playlist
 * @returns {Music} - the current position of the playlist
 */
Playlist.prototype.getCurrentPosition = function () {
    return this.currentPosition;
};

/**
 * Get the current Music
 * @returns {Music} - the current Music
 */
Playlist.prototype.getCurrentMusic = function () {
    return this.currentMusic;
};

/**
 * Get a Music with its position in the playlist
 * @param position - int - Position into the playlist
 * @returns {Music} - Music object
 */
Playlist.prototype.getMusic = function (position) {
    if (this.musicList[position] != null) {
        return this.musicList[position];
    } else {
        return null;
    }
};

/**
 * Add a Music to the playlist
 * @param  music - {Music} object
 */
Playlist.prototype.addMusicInstance = function (music) {
    if (this.currentMusic == null)
        this.currentMusic = music;
    this.musicList.push(music);
    this.generateSuperPlayerPlaylistBlock();
};

/**
 * Add a Music to the playlist
 * @param  music - {Music} object
 */
Playlist.prototype.addMusic = function (music) {
    if (this.currentMusic == null)
        this.currentMusic = music;
    this.musicList.push(music);
    this.generatePlaylistBlock();
};

/**
 * Remove a music with the Music given
 * @param music - Music to remove
 * @returns {boolean} - true if success, else otherwise
 */
Playlist.prototype.removeMusicByMusic = function (music) {
    if (this.musicList.includes(music) && music !== this.currentMusic) {
        if (this.musicList.indexOf(music) < this.currentPosition)
            this.currentPosition--;
        this.musicList.splice(this.musicList.indexOf(music), 1);
        return true;
    } else {
        return false;
    }
};

/**
 * Remove a music with its position into the playlist
 * @param position - position to remove
 * @returns {boolean} - true if success, else otherwise
 */
Playlist.prototype.removeMusicByPosition = function (position) {
    if (this.musicList[position] != null && this.musicList[position] !== this.currentMusic) {
        if (position < this.currentPosition)
            this.currentPosition--;
        this.musicList.splice(position, 1);
        return true;
    } else {
        return false;
    }
};

/**
 * Change if possible the current position for currentPosition + 1
 */
Playlist.prototype.next = function () {
	let musicList = this.player.domElement.querySelectorAll("div.playlist ol.tracklist li.element");
    if (this.currentPosition < musicList.length - 1) {
        this.currentPosition++;
    } else {
        this.currentPosition = 0;
    }
	this.currentMusic = this.musicList[this.currentPosition];
	this.changeSelectedPlaylistElement(musicList[this.currentPosition]);
	this.changePlaylistPlayPauseClass(musicList[this.currentPosition]);
};

/**
 * Change if possible the current position for currentPosition - 1
 */
Playlist.prototype.previous = function () {
	let musicList = this.player.domElement.querySelectorAll("div.playlist ol.tracklist li.element");
    if (this.currentPosition > 0) {
        this.currentPosition--;
		this.currentMusic = this.musicList[this.currentPosition];
    }
	this.changeSelectedPlaylistElement(musicList[this.currentPosition]);
	this.changePlaylistPlayPauseClass(musicList[this.currentPosition]);
};

Playlist.prototype.changePlaylistPlayPauseClass = function (target) {
	let index;
	if (target.classList.contains('image')) {
		index = Number( (target.nextSibling.innerText) -1);
	}else{
		index = Number( (target.firstChild.nextSibling.innerText) -1);
	}
	let currentMusicId = parseInt(this.player.domElement.querySelector(".play-pause").getAttribute("data-currentMusicId"));
	let currentMusicState;
	if ( currentMusicId == index ) {
		currentMusicState = this.player.domElement.querySelector(".play-pause").classList[1];//Recuper l'etat de la musique selon le bouton principal
	}else{
		currentMusicState = "play";
	}
	if (target.classList.contains("play")) {
		target.classList.replace("play", currentMusicState);
	}else if (target.classList.contains("pause")) {
		target.classList.replace("pause", currentMusicState);
	}else{
		target.classList.add(currentMusicState);
	}
	target.setAttribute("src", "../public/images/_icons/" + currentMusicState + ".svg");
};


Playlist.prototype.changeSelectedPlaylistElement = function (target) {
	this.removeSelectedPlaylistElement();
	let index;
	if (target.classList.contains('image')) {
		index = Number( (target.nextSibling.innerText) -1);
	}else{
		index = Number( (target.firstChild.nextSibling.innerText) -1);
	}
	let currentMusicId = parseInt(this.player.domElement.querySelector(".play-pause").getAttribute("data-currentMusicId"));
	if ( currentMusicId !== index ) {
		this.player.domElement.querySelector(".play-pause").setAttribute("data-currentMusicId", index);
		this.player.setPosition(index);//Use to get the good position (var outside effect problem, even with let)
	}
	this.player.play_pause();
	target.classList.add("selected");
	this.changePlaylistPlayPauseClass(target);
};

Playlist.prototype.removeSelectedPlaylistElement = function(){
	let playlistElementSelected = this.player.domElement.querySelectorAll("div.playlist ol.tracklist li.element[class~='selected']");//Array
	for (var i = 0; i < playlistElementSelected.length; i++) {
		playlistElementSelected[i].classList.remove("selected");
	}
};

/**
 * Will generate the block which contains the musics into the playlist
 * @param allMusic {boolean} - If more than 5 musics in the playlist, put "true" to show all, false by default
 */
Playlist.prototype.generatePlaylistBlock = function (allMusic) {

    //Set a default parameter which work with IE11
    allMusic = allMusic || false;

    if (this.musicList.length > 1) {
        let playlistBlock;

		if (this.player.domElement.querySelector(".playlist") !== null) {
            playlistBlock = this.player.domElement.querySelector(".playlist");
            playlistBlock.innerHTML = "";
        } else {
            playlistBlock = document.createElement("div");
            playlistBlock.classList.add("playlist");
        }
        let tracklist = document.createElement("ol");
        tracklist.classList.add("tracklist");

        //Check if the playlist contains 5 music and if it allow, drawn all musics data
        for (let index = 0; index < this.musicList.length && (index < 5 || allMusic); index++) {
            let musicBlock = document.createElement("li");
            musicBlock.classList.add("element");
			if (index == this.currentPosition) {
				musicBlock.classList.add("selected");
			}

            let coverBlock = document.createElement("img");
			coverBlock.classList.add("image");
			coverBlock.setAttribute("style", "background-image: url(" + this.musicList[index].coverPath + ");");
			coverBlock.addEventListener("click", function(e){
				this.changeSelectedPlaylistElement(e.currentTarget);
			}.bind(this));
			coverBlock.addEventListener("mouseover", function(e){
				this.changePlaylistPlayPauseClass(e.currentTarget);
			}.bind(this));

			coverBlock.addEventListener("mouseout", function(e){
				let target = e.currentTarget;
				if (typeof target.classList[1] !== "undefined") {
					let state = target.classList.item(1);
					target.classList.remove(state);
				};
				e.currentTarget.removeAttribute("src");
			}.bind(this));

            let numberBlock = document.createElement("p");
            numberBlock.classList.add("numero");
            numberBlock.innerText = index + 1;


			let divInfos = document.createElement("div");
			divInfos.classList.add('infos');

            let titleBlock = document.createElement("p");
            titleBlock.classList.add("titre");
            titleBlock.innerText = this.musicList[index].title;

            let artistBlock = document.createElement("p");
            artistBlock.classList.add("artiste");
            artistBlock.innerText = this.musicList[index].artistName;

            let statsBlock = document.createElement("p");
            statsBlock.classList.add("stats");
            statsBlock.innerText = PlayerUtils.secondsToReadableTime(this.musicList[index].duration);


			if (this.player.domElement == document.querySelector(".audioplayer-mini")) {
				divInfos.appendChild(titleBlock);
				divInfos.appendChild(artistBlock);
			}

            musicBlock.appendChild(coverBlock);
            musicBlock.appendChild(numberBlock);
			if (this.player.domElement == document.querySelector(".audioplayer-mini")) {
				musicBlock.appendChild(divInfos);
			}else{
				musicBlock.appendChild(titleBlock);
				musicBlock.appendChild(artistBlock);
			}
			musicBlock.appendChild(statsBlock);
            musicBlock.addEventListener("click", function (e) {
				if (e.target !== coverBlock) {
					this.changeSelectedPlaylistElement(e.currentTarget);
				}
            }.bind(this));

            tracklist.appendChild(musicBlock);
        }

        playlistBlock.appendChild(tracklist);

        //If more than 5 musics into the playlist add a button to show them all
        if (this.musicList.length > 5) {
            let moreBlock = document.createElement("a");
            moreBlock.classList.add("more");
            moreBlock.setAttribute("href", "");

            if (allMusic) {
                moreBlock.innerText = "Cacher " + (this.musicList.length - 5) + " titre(s)";

                moreBlock.addEventListener("click", function (e) {
                    e.preventDefault();
                    this.generatePlaylistBlock();
                }.bind(this));
            } else {
                moreBlock.innerText = "Afficher les " + this.musicList.length + " titres";

                moreBlock.addEventListener("click", function (e) {
                    e.preventDefault();
                    this.generatePlaylistBlock(true);
                }.bind(this));
            }

            playlistBlock.appendChild(moreBlock);
        }
		if (this.player.domElement.classList.contains("audioplayer-mini")) {
			this.player.domElement.querySelector('.playlist-pannel').appendChild(playlistBlock);
		}else {
			this.player.domElement.appendChild(playlistBlock);
		}

    }

};

/**
 * Will generate the block which contains the musics into the playlist
 * @param allMusic {boolean} - If more than 5 musics in the playlist, put "true" to show all, false by default
 */
Playlist.prototype.generateSuperPlayerPlaylistBlock = function (allMusic) {
    //Set a default parameter which work with IE11
    allMusic = allMusic || false;

    if (this.musicList.length > 0) {
        let playlistBlock;

		if (this.player.domElement.querySelector(".playlist") !== null) {
            playlistBlock = this.player.domElement.querySelector(".playlist");
            playlistBlock.innerHTML = "";
        } else {
            playlistBlock = document.createElement("div");
            playlistBlock.classList.add("playlist");
        }
        let tracklist = document.createElement("ol");
        tracklist.classList.add("tracklist");

        //Check if the playlist contains 5 music and if it allow, drawn all musics data
        for (let index = 0; index < this.musicList.length && (index < 5 || allMusic); index++) {
            let musicBlock = document.createElement("li");
            musicBlock.classList.add("element");
			if (index == this.currentPosition) {
				musicBlock.classList.add("selected");
			}

            let coverBlock = document.createElement("img");
			coverBlock.classList.add("image");
			coverBlock.setAttribute("style", "background-image: url(" + this.musicList[index].coverPath + ");");
			coverBlock.addEventListener("click", function(e){
				this.changeSelectedPlaylistElement(e.currentTarget);
			}.bind(this));
			coverBlock.addEventListener("mouseover", function(e){
				this.changePlaylistPlayPauseClass(e.currentTarget);
			}.bind(this));

			coverBlock.addEventListener("mouseout", function(e){
				let target = e.currentTarget;
				if (typeof target.classList[1] !== "undefined") {
					let state = target.classList.item(1);
					target.classList.remove(state);
				};
				e.currentTarget.removeAttribute("src");
			}.bind(this));

            let numberBlock = document.createElement("p");
            numberBlock.classList.add("numero");
            numberBlock.innerText = index + 1;

            let titleBlock = document.createElement("p");
            titleBlock.classList.add("titre");
            titleBlock.innerText = this.musicList[index].title;

            let artistBlock = document.createElement("p");
            artistBlock.classList.add("artiste");
            artistBlock.innerText = this.musicList[index].artistName;

            let statsBlock = document.createElement("p");
            statsBlock.classList.add("stats");
            statsBlock.innerText = PlayerUtils.secondsToReadableTime(this.musicList[index].duration/1000);

            musicBlock.appendChild(coverBlock);
            musicBlock.appendChild(numberBlock);
            musicBlock.appendChild(titleBlock);
            musicBlock.appendChild(artistBlock);
			musicBlock.appendChild(statsBlock);
            musicBlock.addEventListener("click", function (e) {
				if (e.target !== coverBlock) {
					this.changeSelectedPlaylistElement(e.currentTarget);
				}
            }.bind(this));

            tracklist.appendChild(musicBlock);
        }

        playlistBlock.appendChild(tracklist);

        //If more than 5 musics into the playlist add a button to show them all
        if (this.musicList.length > 5) {
            let moreBlock = document.createElement("a");
            moreBlock.classList.add("more");
            moreBlock.setAttribute("href", "");

            if (allMusic) {
                moreBlock.innerText = "Cacher " + (this.musicList.length - 5) + " titre(s)";

                moreBlock.addEventListener("click", function (e) {
                    e.preventDefault();
                    this.generatePlaylistBlock();
                }.bind(this));
            } else {
                moreBlock.innerText = "Afficher les " + this.musicList.length + " titres";

                moreBlock.addEventListener("click", function (e) {
                    e.preventDefault();
                    this.generatePlaylistBlock(true);
                }.bind(this));
            }

            playlistBlock.appendChild(moreBlock);
        }
		if (this.player.domElement.classList.contains("audioplayer-mini")) {
			this.player.domElement.querySelector('.playlist-pannel').appendChild(playlistBlock);
		}else {
			this.player.domElement.appendChild(playlistBlock);
		}

    }

};

/**
 * Will redraw the number of views of each music into the playlist
 */
Playlist.prototype.repaintPlaylist = function () {
    let tracklist = this.player.domElement.querySelectorAll(".playlist .tracklist .list li .stats");

    for (let index = 0; index < tracklist.length; index++) {
        tracklist[index].innerText = this.musicList[index].numberView;
    }

};
