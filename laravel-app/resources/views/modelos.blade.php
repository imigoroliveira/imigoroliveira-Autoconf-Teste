<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modelos') }}
        </h2>
        
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-8  m-5">
                        <div id="successAlert" class="alert alert-success" role="alert" style="display: none;">
                            Veículo removido com sucesso!
                        </div>
                        <div class="modal fade" id="imagemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                   
                                    <div class="modal-body">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="criarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Criar Novo Modelo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="criarForm">
                                            <div class="form-group">
                                                <label for="preco">Nome:</label>
                                                <input type="text" class="form-control" id="nome" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="modeloId">Marca:</label>
                                                <select required class="form-control" id="modeloIdMarca" required>
                                            </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-salvar-criacao active">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="confirmacaoExclusaoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmar Exclusão</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir este registro?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary active" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger btn-confirmar-exclusao active">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Modelo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="loader" class="d-flex justify-content-center align-items-center">
                                            <img src="https://i.gifer.com/ZKZg.gif" width="100px" height="100px">
                                        </div>
                                        <form id="editarForm" class="d-none">
                                            <div class="form-group">
                                                <label for="editPreco">Nome:</label>
                                                <input type="text" class="form-control" id="nomeId" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="editMarca">Marca:</label>
                                                <span class="d-none" id="marcaId"></span>
                                                <select class="form-control" id="editMarca" required>
                                                    <option id="firstOption"></option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-salvar">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <button type="button" class="btn btn-success ml-auto mt-3 active" data-toggle="modal" data-target="#criarModal">
                            Adicionar Modelo
                        </button>
                        <table id="modelosTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>Marca</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
  
            </div>
        </div>
    </div>
<script type="text/javascript">   
    $(document).ready(function () {
        var marcasDisponiveis;
        var marca;
        var modelosDisponiveis;

        var table = $('#modelosTable').DataTable({
                "pageLength": 20,
                "ajax": {
                    "url": "/modelos/listar",
                    "type": "GET",
                    "dataType": "json",
                    "dataSrc": function (data) {
                        return data.data;
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nome"},
                    { "data": "marca.nome" },
                    
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            if (type === 'display') {
                                var buttonsHtml = `
                                    <button type="button" class="btn btn-primary btn-sm mx-2 active"  data-toggle="modal" data-target="#editarModal">Editar</button>
                                    <button type="button" class="btn btn-danger btn-sm active">Excluir</button>
                                `;
                                return buttonsHtml;
                            }
                            return null;
                        }
                    }
                ]
            });

            $('button.btn-success').on('click', function () {
                limparFormularioCriacao();
                $('#criarModal').modal('show');
            });


            $('#criarModal').on('click', 'button.btn-salvar-criacao', function () {
            salvarCriacao();
        });



        function limparFormularioCriacao() {
            $('#modeloIdMarca').val('');
            $('#nome').val('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/marcas/listar',
                type: 'GET',
                success: function (marcas) {
                    $('#modeloIdMarca').empty();
                    marcasDisponiveis = marcas.marcas;
                    marcasDisponiveis.forEach(function (marca) {
                        $('#modeloIdMarca').append('<option value="' + marca.id + '">' + marca.nome + '</option>');
                    });

                    var primeiraMarca = marcasDisponiveis[0].id;
                    $('#modeloIdMarca').val(primeiraMarca);
                },
                error: function (error) {
                    console.error('Erro ao obter marcas disponíveis:', error);
                }
            });

        }


        function salvarCriacao() {
            var nome = $('#nome').val();
            var marca_id = $('#modeloIdMarca').val();

            var dadosCriacao = {
                nome: nome,
                marca_id: marca_id,
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/modelos/create',
                type: 'POST',
                data: dadosCriacao,
                success: function (response) {
                    alert("Modelo criado com sucesso!");
                    $('#criarModal').modal('hide');
                    $('#modelosTable').DataTable().ajax.reload();
                },
                error: function (error) {
                    console.error('Erro ao criar modelo:', error);
                }
            });
        }

        $('#modelosTable tbody').on('click', 'a.imagem-link', function (e) {
            e.preventDefault();
            var imageUrl = $(this).data('imagem');
            $('#imagemModal .modal-body').html('<img src="' + imageUrl + '" alt="Imagem Maior" class="img-fluid">');
            $('#imagemModal').modal('show');
        });

        $('#modelosTable tbody').on('click', 'button.btn-primary', function () {
            var data = table.row($(this).parents('tr')).data();
            abrirModalEdicao(data);
            $('#editarModal').modal('show');
        });

        function abrirModalEdicao(data) {
            $('#editarModal #editMarca').empty();
            $('#editarModal #marcaId').val(data.marca.id);
            $('#editarModal #nomeId').val(data.nome);
            $('#editarModal #marcaId').val(data.id); 

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/marcas/listar',
                type: 'GET',
                success: function (response) {
                    marcasDisponiveis = response.marcas;
                    console.log(marcasDisponiveis);
                    
                    var selectMarca = $('#editMarca');
                    selectMarca.empty(); 
                        $('#editarModal #firstOption').val(data.marca.id);
                        $('#editarModal #firstOption').text(data.marca.nome);
                    marcasDisponiveis.forEach(function (marca) {
                        if (marca.id != data.marca.id) {
                            $('#editMarca').append('<option value="' + marca.id + '">' + marca.nome + '</option>');
                        }
                    });
                },
                error: function (error) {
                    console.error('Erro ao buscar modelos:', error);
                },
                complete: function () {
                }
            });

            $('#loader').addClass('d-none').removeClass('d-flex');
            $('#editarForm').removeClass('d-none');
        }

    

        $('#editarModal').on('click', 'button.btn-salvar', function () {
            console.log("Requisição para atualizar os dados");
        });


    $('#modelosTable tbody').on('click', 'button.btn-danger', function () {
        var id = table.row($(this).parents('tr')).data().id;

        $('#confirmacaoExclusaoModal').modal('show');

        $('.btn-confirmar-exclusao').attr('data-id', id);
    });

    $('.btn-confirmar-exclusao').on('click', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/modelos/' + id + '/delete',
            type: 'DELETE',
            success: function (data) {
                if (data.success) {
                    $('#modelosTable').DataTable().ajax.reload();
                    var successAlert = document.getElementById('successAlert');
                    successAlert.style.display = 'block';
                    setTimeout(function () {
                        successAlert.style.display = 'none';
                    }, 3000);
                } else {
                    console.error('Erro ao excluir modelo:', data.message);
                }
            }
        });
        $('#confirmacaoExclusaoModal').modal('hide');
    });

    });


    $('#editarModal').on('click', 'button.btn-salvar', function () {
        salvarEdicao();
    });
    
    function salvarEdicao() {

        var nome = $('#nomeId').val(); 
        var marca_id = $('#editMarca').val();
        var modeloId = $('#marcaId').val(); 
    
        console.log(nome,marca_id,modeloId);
        var dadosAtualizados = {
            nome: nome,
            marca_id: marca_id,
        };


        $('#loader').addClass('d-flex').removeClass('d-none');
        $('#editarForm').addClass('d-none');

        console.log("chgegou");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/modelos/'+ modeloId + "/update",
            type: 'PUT', 
            data: dadosAtualizados,
            success: function (response) {
                alert("Veiculo atualizado com sucesso!");
                $('#editarModal').modal('hide');
                $('#modelosTable').DataTable().ajax.reload();

            },
            error: function (error) {
                console.error('Erro ao atualizar dados:', error);
            }
        });
    }

    </script>
</x-app-layout>

