function DisplayAll() {
    var x = document.getElementById("tbAlbums");
    x.style.display = "block";
    var x2 = document.getElementById("tbArtists");
    x2.style.display = "block";
    var x3 = document.getElementById("tbTracks");
    x3.style.display = "block";
  }

  function DisplayAlbums() {
    var x = document.getElementById("tbAlbums");
    x.style.display = "block";
    var x2 = document.getElementById("tbArtists");
    x2.style.display = "none";
    var x3 = document.getElementById("tbTracks");
    x3.style.display = "none";
  }

  function DisplayArtists() {
    var x = document.getElementById("tbAlbums");
    x.style.display = "none";
    var x2 = document.getElementById("tbArtists");
    x2.style.display = "block";
    var x3 = document.getElementById("tbTracks");
    x3.style.display = "none";
  }

  function DisplayTracks() {
    var x = document.getElementById("tbAlbums");
    x.style.display = "none";
    var x2 = document.getElementById("tbArtists");
    x2.style.display = "none";
    var x3 = document.getElementById("tbTracks");
    x3.style.display = "block";
  }