<?php
include('meta.php');
// Nome da página
$areaAdmin = 'artigos';
// Requires
require_once 'lib/autoload.php';
require_once "lib/utilidades.php";
require_once 'classe/bo/artigosBO.php';
require_once 'classe/vo/artigosVO.php';


$dataHj = date("Y-m-d");
$msgErro = session_start();
?>
</head>
<script type="text/javascript">
    $(document).ready(function() {
        var error = "<?php print($msgErro) ?>";
        if (error != "") {
            $('.msgError').show();
        }
    });
</script>

<body>
    <?php include("header.php"); ?>

    <main role="main" class="container-fluid">

        <div class="col-md-8 offset-md-2">

            <div class="row">
                <div id="header1" class="col p-4 text-center justify-content-center">
                    <h2>Artigos</h2>
                    <hr />
                    <div class="btn-group text-center">
                        <a class="btn btn-primary active" href="artigos.php">Ver Artigos</a>
                    </div><br><br><br>
                    <h4>Adicionar Artigo</h4>
                </div>
            </div>
            <div class="msgError col p-4 text-center">
                <label><?= $msgErro ?></label>
            </div>
            <div class="row">
                <div class="col-12 p-4 full-page">

                    <div class="col p-3">

                        <div class="col-md-10 offset-md-1">

                            <form method="post" action="artigos.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group w-100">
                                        <label for="titulo">Título Artigo</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Insira aqui o título da artigo" maxlength="255" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group" style="width:100%">
                                        <label for="descricao">Descrição/Corpo Artigo</label>
                                        <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success" name="adicionar">Adicionar Artigo</button>
                                </div>

                            </form>

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
    <!-- <script src="../imports/select2/select2.full.min.js"></script> -->
    <script>
        CKEDITOR.replace('descricao', {
            height: '400px',
            // Configure your file manager integration. This example uses CKFinder 3 for PHP.
            filebrowserBrowseUrl: '<?= PATH ?>admin/imports/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '<?= PATH ?>admin/imports/ckfinder/ckfinder.html?type=Images',
            filebrowserUploadUrl: '<?= PATH ?>admin/imports/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: '<?= PATH ?>admin/imports/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
        });

        /**
         * Máscara para filtrar tipo de telefone
         */
        $(document).ready(function() {
            $('#sac').attr('checked', 'checked');
            $('#telefone').mask('0000-000-0000');

            $('#tipoTelefone input[type="radio"]').on('change', function() {
                if ($('input[name=tipoTel]:checked', '#tipoTelefone').val() == 'SAC') {
                    $('#telefone').val('');
                    $('#telefone').mask('0000-000-0000');
                } else if ($('input[name=tipoTel]:checked', '#tipoTelefone').val() == 'Comum') {
                    $('#telefone').val('');
                    $('#telefone').mask('(00)0000-0000');
                }
            });
            $('#ouvidoria').mask('0000-000-0000');

            //Mascaras para telefones de emergência
            $('#foneEmergencia1').mask('0000-000-0000');
            $('#foneEmergencia2').mask('0000-0000');
        });
    </script>
</body>

</html>