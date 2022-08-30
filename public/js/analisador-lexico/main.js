const onChangeEntrada = evento => {
    carregarTokens(evento.target.value.trim());
}

const carregarTokens = async entrada => {
    const tbody = document.getElementById('tbody-tokens');
    
    if(entrada == '') {
        tbody.innerHTML = '';
        return;
    }
    
    const resposta = await getTokens(entrada);

    if(resposta.erro) {
        mostrarAlerta(resposta.mensagem);
    }
    else {
        removerAlerta();
    }

    tbody.innerHTML = '';

    resposta.tokens.forEach(token => tbody.insertAdjacentElement('beforeend', criaLinhaTabelaTokens(token)));
}

const criaLinhaTabelaTokens = ({token, lexema, linhaInicial, linhaFinal, posicaoInicial, posicaoFinal}) => {
    const tr = document.createElement('tr');

    tr.innerHTML = `<td>${token}</td><td>${lexema}</td><td>${linhaInicial}</td><td>${linhaFinal}</td><td>${posicaoInicial}</td><td>${posicaoFinal}</td>`;

    return tr;
}

const getTokens = async entrada => {
    const formData = new FormData();
    
    formData.append('entrada',   entrada);

    const resposta = await fetch(`${document.URL}tokens`, {
        method: 'POST',
        body: formData,
    });

    return await resposta.json();
}

const mostrarAlerta = (mensagem) => {
    document.getElementById('container-alert').innerHTML = `<div class="alert alert-danger" role="alert">${mensagem}</div>`;
}


const removerAlerta= () => {document.getElementById('container-alert').innerHTML = ''};

const campoEntrada = document.getElementById('entrada'); 

campoEntrada.addEventListener('keyup', onChangeEntrada);
campoEntrada.addEventListener('change', onChangeEntrada);