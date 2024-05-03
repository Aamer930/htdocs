<html>

<head>
  <title>Circle Navigator</title>

  <style>
    .container {
      display: grid;
      /* Use grid layout */
      place-items: center;
      /* Center the child elements both horizontally and vertically */
      height: 100vh;
      /* Full viewport height */
    }

    .gallery {
      --g: 8px;
      /* the gap */
      --s: 500px;
      /* the size */
      display: grid;
      /* The grid area for the images */
      justify-content: center;
      /* Horizontal centering */
      align-items: center;
      /* Vertical centering */
      border-radius: 50%;
      margin: 65px;
    }

    .gallery>img {
      grid-area: 1 / 1;
      width: var(--s);
      aspect-ratio: 1;
      object-fit: cover;
      border-radius: 50%;
      transform: translate(var(--_x, 0), var(--_y, 0));
      cursor: pointer;
      font-size: 0;
      z-index: 0;
      transition: 0.3s, z-index 0s 0.3s;
    }

    .gallery img:hover {
      font-size: var(--s);
      z-index: 1;
      transition: transform .2s, font-size .3s .2s, z-index 0s;
    }

    .gallery:hover img {
      transform: translate(0, 0);
    }

    .gallery>img:nth-child(1) {
      clip-path: polygon(50% 50%, .5em 1.2em, 0 1em, 0 0, 100% 0, 100% 1em, calc(100% - .5em) 1.2em);
      --_y: calc(-1*var(--g))
    }

    .gallery>img:nth-child(2) {
      clip-path: polygon(50% 50%, calc(100% - 1.2em) 0.5em, calc(100% - 1em) 0, 100% 0, 100% 100%, calc(100% - 1em) 100%, calc(100% - 1.2em) calc(100% - .5em));
      --_x: var(--g)
    }

    .gallery>img:nth-child(3) {
      clip-path: polygon(50% 50%, calc(100% - .5em) calc(100% - 1.2em), 100% calc(100% - 1.2em), 100% 100%, 0 100%, 0 calc(100% - 1em), .5em calc(100% - 1.2em));
      --_y: var(--g)
    }

    .gallery>img:nth-child(4) {
      clip-path: polygon(50% 50%, 1.2em .5em, 1em 0, 0 0, 0 100%, 1em 100%, 1.2em calc(100% - .5em));
      --_x: calc(-1*var(--g))
    }

    body {
      height: 100%;
      margin: 0;
      background-image: url("./PICS/back11.svg");
      padding: 0;
      background-size: cover;

    }

    #audio {
      position: absolute;
      left: 0;
      bottom: 0;
    }

    .logo {
      font-size: 32px;
      color: rgb(233, 70, 0);
      text-decoration: none;
      font-weight: 700;
      padding-left: 20px;
    }

    .navbar a {
      position: relative;
      font-size: 18px;
      color: rgb(233, 70, 0);
      font-weight: 500;
      text-decoration: none;
      margin-left: 40px;
    }

    .navbar a::before {
      content: '';
      position: absolute;
      top: 100%;
      left: 0;
      width: 0;
      height: 2px;
      background: rgb(233, 70, 0);
      transition: 0.5s;

    }

    .navbar a:hover:before {
      width: 100%;
    }

    .nav-header {
      position: relative;
      width: 100%;
      padding: 30px 10px;
      background-color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;

    }

    li,
    a {
      font-weight: 500;
      font-size: 30px;
      color: rgb(233, 70, 0);
      border: none;
      text-decoration: none;
    }

    .navbar {
      list-style: none;
    }

    .navbar li {
      display: inline-block;
      padding: 0px 20px;
    }

    .navbar li a {
      transition: all 0.3 ease 0;
    }

    .aboutus_butt {
      border: none;
      border-radius: 50px;
      color: rgb(233, 70, 0);
      padding: 16px 16px;
      margin-right: 50px;
    }

    .aboutus_butt:hover {
      border: none;
      border-radius: 50px;
      background-color: rgba(2, 0, 0, 0.8);
      padding: 16px 16px;
      cursor: pointer;
    }

    .navbar_text {
      font-weight: 500;
    }
  </style>
</head>

<body>
  <header class="nav-header">
    <a href="#" class="logo">𓄿𓄿𓂋𓅲</a>
    <nav class="navbar">
      <ul>
        <li><a href="HomePage.php" class="navbar_text">Home</a></li>
        <li><a href="./circleNav.php" class="navbar_text">circleNav</a></li>
        <li><a href="./BookingPage.php" class="navbar_text">book trip</a></li>

      </ul>
    </nav>
    <a href="/AARU/AboutUs/AboutUs.html"><button class="aboutus_butt">about us</button></a>
  </header>



  <div class="gallery">
    <img src="./PICS/TourismTybes/11.png" onclick='window.location.href="./Historical.php"'></img>
    <img src="./PICS/TourismTybes/44.png" onclick='window.location.href="./soon page/SoonRelgion.html"'></img>
    <img src="./PICS/TourismTybes/55.png" onclick='window.location.href="./Soon Page/SoonMedical.html"'></img>
    <img src="./PICS/TourismTybes/Add a subheading1.png"
      onclick='window.location.href="./Soon Page/soonEnter.html"'></img>
  </div>






  <div id="audio">
    <p id="p1">The music is running in the background.</p>
    <audio hidden controls autoplay loop>

      <source src="Audio/Ancient Egyptian Music Pharaoh Ramses II-vslsS-Uu5x4-192k-1710334578.mp3" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>
  </div>

</body>

</html>