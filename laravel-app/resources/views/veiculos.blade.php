<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Veiculos') }}
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
                                        <h5 class="modal-title" id="exampleModalLabel">Criar Novo Veículo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="criarForm">
                                            <div class="form-group">
                                                <label for="modeloId">Modelo:</label>
                                                <select class="form-control" id="modeloIdModelo" required>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="modeloId">Marca:</label>
                                                <select required class="form-control" id="modeloIdMarca" required>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="preco">Preço:</label>
                                                <input type="text" class="form-control" id="preco" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="imagem">Imagem:</label>
                                                <input type="text" class="form-control" id="imagem" required>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Registro</h5>
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
                                                <label for="editId">ID:</label>
                                                <input type="text" class="form-control" id="editId" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="editModelo">Modelo:</label>
                                                <span class="d-none" id="modeloId"></span>
                                                <select class="form-control" id="editModelo" required></select>
                                            </div>
                                            <div class="form-group">
                                                <label for="editPreco">Preço:</label>
                                                <input type="text" class="form-control" id="editPreco" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="editPreco">Imagem:</label>
                                                <input type="text" class="form-control" id="editImagem" required>
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
                            Adicionar Veículo
                        </button>
                        <table id="veiculosTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Preco</th>
                                    <th>Imagem</th>
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

            var table = $('#veiculosTable').DataTable({
                "pageLength": 20,
                "ajax": {
                    "url": "/veiculos/listar",
                    "type": "GET",
                    "dataType": "json",
                    "dataSrc": function (data) {
                        return data.data;
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "marca.nome"},
                    { "data": "modelo.nome" },
                    { "data": "preco"},
                    { "data": "imagem",
                        "render": function (data, type, row) {
                            if (type === 'display') {
                                var buttonsHtml = `
                                    <a href="#" class="imagem-link" data-toggle="modal" data-target="#imagemModal" data-imagem="${data}">
                                        <img src="${data}" alt="Imagem" width="65" height="65">
                                    </a>`;
                                return buttonsHtml;
                            }
                            return data;
                        }
                    },
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
            carregarSelectsModeloMarca();

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
                    modelosDisponiveis = modelos.data;
                    console.log(modelosDisponiveis);

                    modelosDisponiveis.forEach(function (modelo) {

                        $('#modeloIdModelo').append('<option value="' + modelo.id + '">' + modelo.nome + '</option>');
                    });

                    var primeiroModeloId = modelosDisponiveis[0].id;
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
            var modeloId = $('#modeloIdModelo').val();
            var preco = $('#preco').val();
            var imagem = $('#imagem').val();

            var dadosCriacao = {
                modelo_id: modeloId,
                preco: preco,
                imagem: imagem
            };

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/veiculos/create',
                type: 'POST',
                data: dadosCriacao,
                success: function (response) {
                    alert("Veículo criado com sucesso!");
                    $('#criarModal').modal('hide');
                    $('#veiculosTable').DataTable().ajax.reload();
                },
                error: function (error) {
                    console.error('Erro ao criar veículo:', error);
                }
            });
        }

        $('#veiculosTable tbody').on('click', 'a.imagem-link', function (e) {
            e.preventDefault();
            var imageUrl = $(this).data('imagem');
            $('#imagemModal .modal-body').html('<img src="' + imageUrl + '" alt="Imagem Maior" class="img-fluid">');
            $('#imagemModal').modal('show');
        });

        $('#veiculosTable tbody').on('click', 'button.btn-primary', function () {
            var data = table.row($(this).parents('tr')).data();
            abrirModalEdicao(data);
        });

        function abrirModalEdicao(data) {
            $('#editarModal').modal('show');

            $('#editarModal #editId').val(data.id);
            $('#editarModal #editPreco').val(data.preco);
            $('#editarModal #editImagem').val(data.imagem);
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/modelos/listar',
                type: 'GET',
                success: function (response) {
                    modelosDisponiveis = response.data;
                    $('#loader').addClass('d-none').removeClass('d-flex');
                    $('#editarForm').removeClass('d-none');

                    var selectModelo = $('#editModelo');
                    selectModelo.empty();
                    modelosDisponiveis.forEach(function (modelo) {
                        selectModelo.append('<option value="' + modelo.id + '">' + modelo.nome + '</option>');
                        selectModelo.val(data.modelo.id);

                    });
                },
                error: function (error) {
                    console.error('Erro ao buscar modelos:', error);
                }
            });
            
         
          
        }


    $('#veiculosTable tbody').on('click', 'button.btn-danger', function () {
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
            url: '/veiculos/' + id + '/delete',
            type: 'DELETE',
            success: function (data) {
                if (data.success) {
                    $('#veiculosTable').DataTable().ajax.reload();
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
        var id = $('#editId').val();
        var modeloId = $('#editModelo').val(); 
        var preco = $('#editPreco').val();
        var imagem = $('#editImagem').val();

        var dadosAtualizados = {
            id: id,
            modelo_id: modeloId,
            preco: preco,
            imagem: imagem
        };


        $('#loader').addClass('d-flex').removeClass('d-none');
        $('#editarForm').addClass('d-none');


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/veiculos/'+ id + "/update",
            type: 'PUT', 
            data: dadosAtualizados,
            success: function (response) {
                alert("Veiculo atualizado com sucesso!");
                $('#editarModal').modal('hide');
                $('#veiculosTable').DataTable().ajax.reload();

            },
            error: function (error) {
                console.error('Erro ao atualizar dados:', error);
            }
        });
    }

    </script>
</x-app-layout>

