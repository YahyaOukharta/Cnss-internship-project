<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand "style="width:7%;" href="#">
  	<img class="img-fluid" src="img/cnss.logo.png">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-brand" href="#">Remboursement des caisses etrangeres</div>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item <?php if($_SERVER['PHP_SELF']=="/cnss/consulter.php")echo "active"; ?>
">
        <a class="nav-link" href="consulter.php">Consulter les fichiers <span class="sr-only"></span></a>
      </li>
      <li class="nav-item <?php if($_SERVER['PHP_SELF']=="/cnss/importer.php")echo "active"; ?>">
        <a class="nav-link" href="importer.php">Importer un fichier .csv</a>
      </li>

    </ul>
  </div>
</nav>