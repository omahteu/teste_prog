<?php
include('meta.php');

// Nome da página
$areaAdmin = 'principal';
?>
</head>
<body>
    <?php include("header.php"); ?>

    <main role="main" class="container-fluid">

        <div class="col-md-8 offset-md-2">
            <div class="row">
                <div id="header1" class="col p-4 text-center">
                    <h2>Principal</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12 p-4 full-page">
                    
                    <div class="m-3 text-center justify-content-center">
                        <p>Este é o painel de administração do seu site. Utilize as abas acima para navegar e gerenciar o conteúdo.</p>
                        <!-- <img src="../img/logo.png" width="301" height="314"> -->
                    </div>


                    <?php include "footer.php" ?>
                </div>
            </div>
        </div>

    </main>
</body>
</html>