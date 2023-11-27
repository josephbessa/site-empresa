$(document).ready(function () {
    $('.btn-excluir').click(function () {
        var id = $(this).data('id');

        // Preencher o campo do modal de exclusão
        $('#excluir_id_servico').val(id);

        // Mostrar o modal de exclusão
        $('#excluirServicoModal').modal('show');
    });

    $('.btn-editar').click(function () {
        var id = $(this).data('id');

        // Preencher os campos do modal de edição
        var nome = $('#row_' + id + ' td:eq(0)').text();
        var descricao = $('#row_' + id + ' td:eq(1)').text();
        var preco = $('#row_' + id + ' td:eq(2)').text().replace('R$ ', '').replace(',', '.');

        // Preencher os campos do formulário de edição
        $('#edit_id_servico').val(id);
        $('#edit_nome_servico').val(nome);
        $('#edit_descricao').val(descricao);
        $('#edit_preco').val(preco);

        // Mostrar o modal de edição
        $('#editarServicoModal').modal('show');
    });
});