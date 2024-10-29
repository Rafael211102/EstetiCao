function formatarCPF() {
    const input = document.getElementById('cpf');
    let valor = input.value;

    // Remove caracteres não numéricos
    valor = valor.replace(/\D/g, '');

    // Formata o valor do CPF
    if (valor.length <= 3) {
        valor = valor;
    } else if (valor.length <= 6) {
        valor = valor.slice(0, 3) + '.' + valor.slice(3);
    } else if (valor.length <= 9) {
        valor = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6);
    } else if (valor.length <= 11) {
        valor = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6, 9) + '-' + valor.slice(9);
    }

    // Atualiza o valor do input com a formatação
    input.value = valor;
}

function formatarTelefone() {
    const input = document.getElementById('telefone');
    let valor = input.value;

    // Remove caracteres não numéricos
    valor = valor.replace(/\D/g, '');

    // Adiciona a formatação ao valor
    if (valor.length <= 2) {
        valor = '(' + valor;
    } else if (valor.length <= 3) {
        valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
    } else if (valor.length <= 7) {
        valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 3) + ' ' + valor.slice(3);
    } else if (valor.length <= 11) {
        valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 3) + ' ' + valor.slice(3, 7) + '-' + valor.slice(7);
    } else {
        valor = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 3) + ' ' + valor.slice(3, 7) + '-' + valor.slice(7, 11);
    }

    // Atualiza o valor do input com a formatação
    input.value = valor;
}
