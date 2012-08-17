<p id="player_<?php echo $oSong->getId(); ?>"><?php echo $oSong->getFileName(); ?></p>  
<script type="text/javascript">  
    AudioPlayer.embed("player_<?php echo $oSong->getId(); ?>", {soundFile: "<?php echo base_url() . 'assets/songs/' . $oSong->getFullPath(); ?>"});  
</script>