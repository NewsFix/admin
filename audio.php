<script type="text/javascript">
var audio = new Audio("pinoko.mp3");

function play() {
    audio.loop = true;
    audio.volume = 0.1;
    audio.play();
}

play();

</script>

<audio id="audio" muted loop>
<source src="pinoko.mp3" type="audio/mp3">
<source src="pinoko.wav" type="audio/wav">
</audio>
