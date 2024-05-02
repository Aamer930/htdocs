<html>

<head>
    <title>Historical HomePage</title>
    <link rel="stylesheet" href="HomePage.css">
    <link rel="stylesheet" href="Historical.CSS">

</head>

<body>
<header class="nav-header">
            <a href="#" class="logo">𓄿𓄿𓂋𓅲</a>
            <nav class="navbar">
                <ul>
                    <li><a href="./HomePage.php" class="navbar_text">Home</a></li>
                    <li><a href="./circleNav.php" class="navbar_text">circleNav</a></li>
                    <li><a href="./BookingPage.php" class="navbar_text">book trip</a></li>
                    
                </ul>
            </nav>
            <a href="#"><button class="aboutus_butt">about us</button></a>
        </header>

    <header>
        <img id="header1" src="./PICS/traslogo.png" />
    </header>

    <br>
    <video id="VideoMain" src="./Videos/Ancient Egypt 101.mp4" controls autoplay></video>
    <h1 id="HomeHeader">
        Why Ancient Egypt is important ?
    </h1>
    <p id="HomeP1">

        Ancient Egypt is very important because it made significant contributions to world culture and knowledge,
        including architecture, mathematics, and medicine. Its pyramids and art are lasting symbols of human
        achievement, and its hieroglyphic writing system and calendar advancements helped lay the foundations for modern
        science and history. Additionally, the study of ancient Egypt offers insights into one of the world's earliest
        and most enduring civilizations, influencing subsequent cultures and societies.
    </p>

    <h1 id="HomeHeader">
        What Ancient Egypt affect our world ?
    </h1>
    <p id="HomeP1">

        Ancient Egypt has affected our world in numerous ways, including advancements in architecture, art, and science.
        The architectural techniques used in building the pyramids have influenced modern engineering and construction.
        Egyptian art, with its emphasis on order and beauty, has inspired generations of artists and designers.
        Innovations in mathematics, astronomy, and medicine by the Egyptians have laid foundational principles for these
        fields. Furthermore, the concept of written language and record-keeping pioneered by the Egyptians has had a
        profound impact on the development of civilizations and the way history is chronicled today.</p>














        <div class="button-container">
            <a href="./Article pages/ArticleHome.php"> <button type="button" class="button1">CONTINUE</button></a>
        </div>
    <br>
    <br>
    <br>
    <br>
    <audio id="BackgroundMusic" controls autoplay loop>
        <source src="Audio/Ancient Egyptian Music Pharaoh Ramses II-vslsS-Uu5x4-192k-1710334578.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <p id="p1">The music is running in the background.</p>

    <script>
        // JavaScript to play video once and then play the audio
        document.addEventListener('DOMContentLoaded', function () {
            var video = document.getElementById('VideoMain');
            var audio = document.getElementById('BackgroundMusic');

            // Mute the audio initially
            audio.muted = true;

            video.onended = function () {
                // Unmute and play the audio once the video has ended
                audio.muted = false;
                audio.play();
            };
        });
    </script>
</body>

</html>