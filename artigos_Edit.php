<?php
include('meta.php');
if($_GET['id'] === null)
{
    $URL="./artigos.php";
    // header('Location: banner.php');
    // die();
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    exit();
}

// Nome da página
$areaAdmin = 'artigos';
// Requires
require_once "lib/utilidades.php";
require_once "lib/autoload.php";
require_once 'classe/bo/artigosBO.php';
require_once 'classe/vo/artigosVO.php';
// require_once '../config.php';
    
session_start();
$vo = new artigosVO();
$bo = new artigosBO();
$artigos = $bo->Get($_GET['id']);

?>
</head>
<body>
    <?php include("header.php"); ?>

    <main role="main" class="container-fluid">

        <div class="col-md-8 offset-md-2">

            <div class="row">
                <div id="header1" class="col p-4 text-center justify-content-center">
                    <h2>Artigos</h2>
                    <hr/>
                    <h4>Editar Artigo</h4>
                </div>
            </div>
            <div class="msgError col p-4 text-center">
                <label><?=$msgErro?></label>
            </div>

            <div class="row">
                <div id="header2" class="col-12 p-2 text-center">
                    <div class="btn-group text-center">
                        <a class="btn btn-primary" href="artigos.php">Ver Artigos</a>
                        <a class="btn btn-primary" href="artigos_Add.php">Adicionar Artigo</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 p-4 full-page">

                    <div class="col p-3">

                        <div class="col-md-10 offset-md-1">


                                    <form method="post" action="artigos.php" enctype="multipart/form-data">

                                        <?php
                                            if (!empty($artigos)) {
                                                foreach ($artigos as $item) : ?>
                                                    <div class="row">
                                                        <div class="form-group w-100">
                                                            <label for="titulo">Titulo Artigo</label>
                                                            <input type="text" class="form-control" id="titulo" value="<?=urldecode($item['titulo'])?>" name="titulo" placeholder="Insira aqui o título da artigo" maxlength="255" required/>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group" style="width:100%">
                                                        <label for="descricao">Descrição/Corpo Artigo</label>
                                                        <textarea id="descricao" name="descricao" class="form-control" required><?=urldecode($item['descricao'])?></textarea>
                                                    </div>
                                                    </div>
                                                    
                                                    <input type="text" name="id" id="id" value="<?=urldecode($item['id'])?>" hidden>
                                                    <div class="form-group text-center">
                                                        <button type="submit" class="btn btn-success" name="editar" id="editar">Salvar Artigo</button>
                                                    </div>
                                                <?php endforeach;
                                            } else {} ?>
                                    </form><hr>



                        </div>

                    </div>
                    <hr>
                    <?php include "footer.php"; ?>
                </div>
            </div>

        </div>

    </main>
    <!-- <script src="../imports/select2/select2.full.min.js"></script> -->
    <script src="imports/ckeditor/ckeditor.js"></script>
    <script src="../imports/select2/select2.full.min.js"></script>
    <script>
    CKEDITOR.replace('descricao',{
        height:'400px',
        // Configure your file manager integration. This example uses CKFinder 3 for PHP.
        filebrowserBrowseUrl: '<?=PATH?>admin/imports/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: '<?=PATH?>admin/imports/ckfinder/ckfinder.html?type=Images',
        filebrowserUploadUrl: '<?=PATH?>admin/imports/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '<?=PATH?>admin/imports/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
    });

    $(document).ready(function(){
        $('#tipoTelefone input[type="radio"]').on('change', function() {
            if ($('input[name=tipoTel]:checked', '#tipoTelefone').val() == 'SAC') {
                $('#telefone').val('<?=$item->sac != null ? $item->sac :''?>');
                $('#telefone').mask('0000-000-0000');
            } 
            else if ($('input[name=tipoTel]:checked', '#tipoTelefone').val() == 'Comum') {
                $('#telefone').val('<?=$item->telefone != null ? $item->telefone :''?>');
                $('#telefone').mask('(00)0000-0000');
            }
        });
        $('#foneEmergencia1').mask('0000-000-0000');
        $('#foneEmergencia2').mask('0000-0000');
    });    
</script>
</body>
</html>
