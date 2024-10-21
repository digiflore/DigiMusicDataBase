function DisplayAll() {
    var x = document.getElementsById("tbAlbums");
    x.style.display = "block";
    var x2 = document.getElementsById("tbArtists");
    x2.style.display = "block";
    var x3 = document.getElementsById("tbTracks");
    x3.style.display = "block";
  }

  function DisplayAlbums() {
    var x = document.getElementsById("tbAlbums");
    x.style.display = "block";
    var x2 = document.getElementsById("tbArtists");
    x2.style.display = "none";
    var x3 = document.getElementsById("tbTracks");
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
    var x = document.getElementsById("tbAlbums");
    x.style.display = "none";
    var x2 = document.getElementsById("tbArtists");
    x2.style.display = "none";
    var x3 = document.getElementsById("tbTracks");
    x3.style.display = "block";
  }