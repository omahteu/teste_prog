<nav id="navbarHeader" class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="https://legulas.com.br/">
        <img src="style/img/logo.png" width="50">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- <style type="text/css">
            #topo{background-color:#0080A1;background: url(http://www.bossabar.com.br/imgs/bg-index.png) top center no-repeat;margin-top: 30px;margin-bottom: 30px;}
            body{background-color: #0081A1;}
    </style> -->
    <div class="collapse navbar-collapse" id="navbarCollapse">

        <ul class="navbar-nav mr-auto">
            
            <li class="nav-item <?php if(preg_match("/principal/i", $areaAdmin)) { echo 'active'; } ?>">
                <a class="nav-link" href="index.php">Início</a>
            </li>
            <li class="nav-item <?php if(preg_match("/artigos/i", $areaAdmin)) { echo 'active'; } ?>">
                <a class="nav-link" href="artigos.php">Artigos</a>
            </li>            
        </ul>

        <ul class="navbar-nav mt-md-0">
            
            <li class="nav-item">
                <a class="nav-link" href="processausuarios.php?operacao=sair">Sair</a>
            </li>

        </ul>
    </div>
</nav>


<!-- <?php 

echo '<pre>'.var_dump($_SESSION).'</pre>';

    if(isset($_SESSION['msgError'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  '.$_SESSION["msgError"].'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>';

        unset($_SESSION['msgError']);
    }
    if(isset($_SESSION['msgSuccess'])){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  '.$_SESSION["msgSuccess"].'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>';

        unset($_SESSION['msgSuccess']);
    }
?> -->