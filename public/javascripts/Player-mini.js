var menuButton = document.querySelector('.audioplayer-mini .menu .menu-button');
var volumeButton1 = document.querySelector('.audioplayer-mini .controls2 .volume .volume-button');
var volumeButton2 = document.querySelector('.audioplayer-mini .menu-pannel .volume-button');
var shareButton = document.querySelector('.audioplayer-mini .timer .social .share .share-button');
var playlistButton = document.querySelector('.audioplayer-mini .playlist .playlist-button');

var menuPannel = document.querySelector('.audioplayer-mini .menu-pannel');
var volumePannel = document.querySelector('.audioplayer-mini .controls2 .volume .volume-slider');
var sharePannel = document.querySelector('.audioplayer-mini .timer .social .share .share-pannel');
var playlistPannel = document.querySelector('.audioplayer-mini .playlist-pannel');

menuButton.addEventListener('click', function(e){
  if (menuPannel.classList.contains("menu-visible")) {
      menuPannel.classList.remove("menu-visible");
      menuPannel.classList.add("menu-hidden");
  } else {
      menuPannel.classList.remove("menu-hidden");
      menuPannel.classList.add("menu-visible");
  }
}, true );

volumeButton1.addEventListener('click', function(e){
  if (volumePannel.classList.contains("volume-visible")) {
      volumePannel.classList.remove("volume-visible");
      volumePannel.classList.add("volume-hidden");
  } else {
      volumePannel.classList.remove("volume-hidden");
      volumePannel.classList.add("volume-visible");
  }
}, true );

volumeButton2.addEventListener('click', function(e){
  if (volumePannel.classList.contains("volume-visible")) {
      volumePannel.classList.remove("volume-visible");
      volumePannel.classList.add("volume-hidden");
  } else {
      volumePannel.classList.remove("volume-hidden");
      volumePannel.classList.add("volume-visible");
  }
}, true );

shareButton.addEventListener('click', function(e){
  if (sharePannel.classList.contains("share-visible")) {
      sharePannel.classList.remove("share-visible");
      sharePannel.classList.add("share-hidden");
  } else {
      sharePannel.classList.remove("share-hidden");
      sharePannel.classList.add("share-visible");
  }
}, true );



playlistButton.addEventListener('click', function(e){
  if (playlistPannel.classList.contains("playlist-visible")) {
      playlistPannel.classList.remove("playlist-visible");
      playlistPannel.classList.add("playlist-hidden");
  } else {
      playlistPannel.classList.remove("playlist-hidden");
      playlistPannel.classList.add("playlist-visible");
  }
}, true );
