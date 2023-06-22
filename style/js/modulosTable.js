var modulos = new Array();
var modulosCount = 0;

$(document).ready(function() {

    // Modulos           
    var error = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro:</strong>Por favor recarrega a página.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'

    // Adiciona os módulos do curso toda vez que o curso foi alterado
    $("#curso").change(function() {
        var curso = "";

        // Limpa tabela
        removeAllModulos();

        // Limpa opções de modulos
        clearManualModuloOptions();

        // Pega a opção selecionada
        $("#curso option:selected").each(function() {
            curso = $(this).val();
        }); 

        $.ajax({
            url: "ajaxLoadModulos.php?id=" + curso,
            success: function(response) {
                response = JSON.parse(response);

                if (response.status == "success")
                {
                    // Verifica se há modulos para adicionar
                    if (response.data != null) {
                        // Adiciona módulos
                        for (var i = 0; i < response.data.length; i++) {
                            addModulo(response.data[i]);

                            // adiciona opção ao escolha manual do modulos
                            addManualModuloOption(response.data[i]);
                        }
                    }
                }
                else
                {
                    // ajaxLoadModulos.php error
                    console.error(response);

                    $(".full-page").append(error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Ajax request error
                $(".full-page").append(error);
            }
        });

    });

});

function addModulo(item, setedDate = null) {
    // Identificador é formado pela quantidade de modulos
    var id = 'mId-' + modulosCount;
    var moduloId = 'mdata-' + modulosCount;

    var name = '<th scope="row">' + item.nome + '</th>';

    var date = '<td>';

        date += '<input type="hidden" name="' + id + '" value="'+ item.id +'" />';

        date += '<input type="text" class="date-input form-control" id="' + moduloId + '" name="' + moduloId + '" ';

        // adiciona uma data padrão
        if (setedDate != null) {
            date += ' value="' + setedDate + '" ';
        }

        date += ' />';

    date += '</td>';

    var actions = '<td><div class="btn-group-vertical">';

        // Botão para duplicar
        actions += '<button type="button" class="btn btn-sm btn-secondary" onclick="duplicateModulo(';
        actions +=  modulosCount;
        actions += ');">Duplicar</button>';

        // Botão para remover
        actions += '<button type="button" class="btn btn-sm btn-danger" onclick="removeModulo('+ modulosCount +');">Remover</button>';

    actions += '</td>';

    // Adiciona modulo ao array de modulos
    modulos.push(item);

    // Chama a tabela da página (anteriormente definida)
    table.row.add( [
        name,
        date,
        actions
    ] ).draw();

    // Adiciona mascaras ao campo de data
    $("#" + moduloId).mask("99/99/9999");

    // Aumenta a quantidade de modulos
    modulosCount++;

    // Atualiza o campo que armazena a quantidade total de modulos
    $("#modulosLength").val(modulosCount);
}

function removeAllModulos() {
    // Limpa variavel dos modulos
    modulos = new Array();

    // Reseta quantidade de modulos
    modulosCount = 0;

    // Limpa tabela
    table.clear().draw();

    // Atualiza o campo que armazena a quantidade total de modulos
    $("#modulosLength").val(modulosCount);
}

function duplicateModulo (itemIndex) {
    // Chama o método de adicionar um módulo
    addModulo(modulos[itemIndex]);
}

function removeModulo (itemIndex) {
    // Seta elemento do array para null (por causa do backend)
    modulos[itemIndex] = null;

    // Adicione uma classe à linha da tabela para remover
    $("#mdata-" + itemIndex).parent().parent().addClass("remove");

    // Remove elemento do html
    table.row('.remove').remove().draw();

    // Diminui a quantidade de modulos
    modulosCount--;

    // Atualiza o campo que armazena a quantidade total de modulos
    $("#modulosLength").val(modulosCount);
}

function addManualModuloOption(item) {
    var element = '<option value="' + item.id + '">' + item.nome + '</option>';

    // Destroi select
    $("#modulos").select2("destroy");

    // Adiciona option
    $("#modulos").append(element);

    // Recria o selct
    $("#modulos").select2();
}

function clearManualModuloOptions () {
    // Destroi select
    $("#modulos").select2("destroy");

    // Remove todos os elementos  filhos
    $("#modulos").empty();

    // Recria o selct
    $("#modulos").select2();
}