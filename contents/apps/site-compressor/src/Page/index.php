<?php
$this->setTitle("Site Compressor");
?>
<div class="contents" style="margin-top: 100px;">
  <center>
    <div style="margin-bottom: 20px;">
      <a class="button" href="<?php echo \Lobby\App::u("/site");?>"><h2>Compress A Site</h2></a>
    </div>
    <div style="margin-bottom: 20px;">
      <a class="button"  href="<?php echo \Lobby\App::u("/html");?>">Compress Hyper Text Markup Language (HTML)</a>
    </div>
    <a class="button" href="<?php echo \Lobby\App::u("/css");?>">Compress Cascading Style Sheet (CSS)</a>
    <a class="button" href="<?php echo \Lobby\App::u("/js");?>">Compress JavaScript (JS)</a>
  </center>
</div>
