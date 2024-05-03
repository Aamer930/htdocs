<html>

<head>
    <title>AARU Home Page AMIN</title>
    <link rel="stylesheet" href="HomePage.css">

</head>

<body>
  <header class="nav-header">
            <a href="#" class="logo">𓄿𓄿𓂋𓅲</a>
            <?php
session_start();
if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
    echo 'HELLO, '.$_SESSION['first_name'].' '.$_SESSION['last_name'];
} else {
    echo 'Session variables are not set.';
}
session_unset();
?>
            <nav class="navbar">
                <ul>
                    <li><a href="/AARU/HomePage.php" class="navbar_text">Home</a></li>
                    <li><a href="/AARU/circleNav.php" class="navbar_text">circleNav</a></li>
                    <li><a href="/AARU/Admin/Admin.php" class="navbar_text">Publish trip</a></li>
                    
                </ul>
            </nav>
            <a href="/AARU/AboutUs/AboutUs.html"><button class="aboutus_butt">ABOUT US!!</button></a>
        </header>

    <header>
        <img id="header1" src="./PICS/traslogo.png" />
    </header>
    <h1 id="HomeHeader">
        What is Meant by AARU ?
    </h1>
    <p id="HomeP1">
        AARU is the name for heavenly paradise in Egyptian mythology.
        Ruled over by Osiris, an Egyptian god, the location has been described as the ka of the Nile Delta.In Ancient
        Egypt, the afterlife held deep significance, with the soul's journey meticulously guided by intricate beliefs.
        Central to this was the "Weighing of the Heart," where a person's heart was weighed against the feather of Maat,
        representing truth. Those deemed righteous embarked on a perilous journey through guarded gates to reach Aaru, a
        paradise in the east with reed-covered islands. Here, they found eternal peace and pleasure, while Osiris
        presided over the "field of offerings." This succinctly encapsulates the profound spirituality and symbolism of
        Ancient Egyptian beliefs about the afterlife.
    </p>
    <h1 id="HomeHeader">
        Why Discover The Truth Of AARU ?
    </h1>
    <p id="HomeP1">
        Discover the wonders of Egypt our AARU, a land brimming with history and home to the legendary stories of kings,
        queens, and ancient temples. From the majestic pyramids to the enigmatic Sphinx, Egypt's past is as rich as it
        is fascinating. Embark on a journey to explore this treasure of heritage, where each site tells tales of ancient
        wisdom and marvel. This adventure isn't just about seeing; it's about uncovering the secrets of humanity's quest
        for understanding and enlightenment. With four main types of tourism—entertainment, historical, medical, and
        religious—we invite you to discover every aspect that interests you. Choose the places that call to you, book
        your trip, and dive into the fun. Egypt is waiting to reveal its truths to you, one incredible experience at a
        time.</p>


    <div class="button-container">
        <a href="./circleNav.php"> <button type="button" class="button1">Lets Start the JOURNEY OF AARU !</button></a>
    </div>




    <audio hidden controls autoplay loop>
        <source src="Audio/Ancient Egyptian Music Pharaoh Ramses II-vslsS-Uu5x4-192k-1710334578.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <p id="p1">The music is running in the background.</p>
    <div class="gallery">
        <a target="_blank" href="./PyramidModule.html">
            <img src="./PICS/sticky.png" alt="Pyramids" id="stcphpyr" />
        </a>
    </div>
    </div>
</body>

</html>