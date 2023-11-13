<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marcas') }}
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
                                        <h5 class="modal-title" id="exampleModalLabel">Criar Novo Marca</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="criarForm">
                                       
                        
                                            <div class="form-group">
                                                <label for="preco">Nome:</label>
                                                <input type="text" class="form-control" id="nomeInput" required>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Marca</h5>
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
                                                <label for="editModelo">Nome:</label>
                                                <input type="text" class="form-control" id="nome" required>
                                                <span id="nomeId" class="d-none"></span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-salvar active">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <button type="button" class="btn btn-success ml-auto mt-3 active" data-toggle="modal" data-target="#criarModal">
                            Adicionar Marca
                        </button>
                        <table id="marcasTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
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
        var modelosDisponiveis;

            var table = $('#marcasTable').DataTable({
                "pageLength": 20,
                "ajax": {
                    "url": "/marcas/listar",
                    "type": "GET",
                    "dataType": "json",
                    "dataSrc": function (data) {
                        console.log(data);

                        return data.marcas;
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "nome"},
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
            $('#modeloIdModelo').val('');
            $('#preco').val('');
            $('#imagem').val('');

        }

        function carregarSelectsModeloMarca() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/modelos/listar',
                type: 'GET',
                success: function (modelos) {
                    $('#modeloIdModelo').empty();
                    modelosDisponiveis = modelos;

                    modelos.forEach(function (modelo) {
                        $('#modeloIdModelo').append('<option value="' + modelo.id + '">' + modelo.nome + '</option>');
                    });

                    var primeiroModeloId = modelos[0].id;
                    $('#modeloIdModelo').val(primeiroModeloId);
                    buscaMarcaPorModelo(primeiroModeloId);
                },
                error: function (error) {
                    console.error('Erro ao obter modelos disponíveis:', error);
                }
            });
            $('#modeloIdModelo').trigger('change');
        }







        $('#modeloIdModelo').change(function () {
            var modeloSelecionadoId = $(this).val();
            buscaMarcaPorModelo(modeloSelecionadoId);
        });

        function buscaMarcaPorModelo(id){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/marcas/get/'+id,
            type: 'GET',
            success: function (modelo) {
                $('#modeloIdMarca').empty();
                $('#modeloIdMarca').append('<option value="' + modelo.id + '">' + modelo.nome + '</option>');
            },
            error: function (error) {
                console.error('Erro ao obter modelos disponíveis:', error);
            }
        });
    }

        function salvarCriacao() {
            var nomeInput = $('#nomeInput').val();     

            var dadosCriacao = {
                nome: nomeInput,
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/marcas/create',
                type: 'POST',
                data: dadosCriacao,
                success: function (response) {
                    alert("Veículo criado com sucesso!");
                    $('#criarModal').modal('hide');
                    $('#marcasTable').DataTable().ajax.reload();
                },
                error: function (error) {
                    console.error('Erro ao criar veículo:', error);
                }
            });
        }

        $('#marcasTable tbody').on('click', 'a.imagem-link', function (e) {
            e.preventDefault();
            var imageUrl = $(this).data('imagem');
            $('#imagemModal .modal-body').html('<img src="' + imageUrl + '" alt="Imagem Maior" class="img-fluid">');
            $('#imagemModal').modal('show');
        });

        $('#marcasTable tbody').on('click', 'button.btn-primary', function () {
            var data = table.row($(this).parents('tr')).data();
            abrirModalEdicao(data);
            $('#editarModal').modal('show');
        });

        function abrirModalEdicao(data) {
            $('#editarModal #nomeId').val(data.id);
            $('#editarModal #nome').val(data.nome);

            $('#loader').addClass('d-none').removeClass('d-flex');
            $('#editarForm').removeClass('d-none');
        }

        $('#editarModal').on('click', 'button.btn-salvar', function () {
            console.log("Requisição para atualizar os dados");
        });


    $('#marcasTable tbody').on('click', 'button.btn-danger', function () {
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
            url: '/marcas/' + id + '/delete',
            type: 'DELETE',
            success: function (data) {
                if (data.success) {
                    $('#marcasTable').DataTable().ajax.reload();
                    var successAlert = document.getElementById('successAlert');
                    successAlert.style.display = 'block';
                    setTimeout(function () {
                        successAlert.style.display = 'none';
                    }, 3000);
                } else {
                    console.error('Erro ao excluir veiculo:', data.message);
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
        var nome = $('#nome').val(); 
        var marcaId = $('#nomeId').val();


        var dadosAtualizados = {
            nome: nome
        };


        $('#loader').addClass('d-flex').removeClass('d-none');
        $('#editarForm').addClass('d-none');

        console.log("chgegou");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/marcas/'+ marcaId + "/update",
            type: 'PUT', 
            data: dadosAtualizados,
            success: function (response) {
                alert("Veiculo atualizado com sucesso!");
                $('#editarModal').modal('hide');
                $('#marcasTable').DataTable().ajax.reload();

            },
            error: function (error) {
                console.error('Erro ao atualizar dados:', error);
            }
        });
    }

    </script>
</x-app-layout>

