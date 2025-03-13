
const cepInput = document.querySelector('#cep');
const errorMsg = document.querySelector('#error');
const cepBtn = document.querySelector('#cepBtn');

cepInput.addEventListener('input', function(){
    cepInput.value = cepInput.value.replace(/\D/g, '');

    if(cepInput.value.length > 8){
        cepInput.value = cepInput.value.slice(0, 8);
    }
})


document.querySelector('#formCep').addEventListener('submit', function(event){
    event.preventDefault();

    const cep = cepInput.value;

    if(cep.trim() === ''){
        errorMsg.style.display = 'block';
        errorMsg.textContent = 'Digite um CEP';
        cepInput.focus();
        return;
    }else if(cep.length < 8 || cep.length > 8){
        errorMsg.style.display = 'block';
        errorMsg.textContent = 'O CEP deve ter 8 digitos';
        cepInput.focus();
        return;
    }else{
        errorMsg.style.display = 'none';
        errorMsg.textContent = '';
        cepBtn.value = 'Procurando';
        cepBtn.disabled = true;
    }

    const inputs = document.querySelectorAll('.inputInfo');
    const numero = document.querySelector('#numero');

    numero.addEventListener('input', function(){
        numero.value = numero.value.replace(/\D/g, '');
        if(numero.value > 5){
            numero.value = numero.value.slice(0, 5);
        }
    })
    
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
    .then(response => response.json())
    .then(data => {
        if(data.cep){
            if(data.localidade == 'Jaú' && data.uf == 'SP' ){
                const dadosCep = [
                    data.estado,
                    data.localidade,
                    data.bairro,
                    data.logradouro
                ];
        
                inputs.forEach((input, i) => {
                    input.value = dadosCep[i];
                })
        
                document.querySelector('#cepInfos').style.display = 'flex';
                cepBtn.value = 'Verificar CEP';
                cepBtn.disabled = false;

                const idUsuario = document.querySelector('#id_usuario').value;
                const adminUsuario = document.querySelector('#admin_usuario').value;
                const errorNumero = document.querySelector('#errorNumero');

                document.querySelector('#cepInfos').addEventListener('submit', function(event){
                    event.preventDefault();
                    if(numero.value <= 0){
                        numero.style.borderColor = 'red';
                        errorNumero.style.display = 'block';
                        errorNumero.textContent = 'Digite um número válido';
                    }else{
                        cadastrarEndereco(idUsuario, adminUsuario, data.localidade, data.logradouro, data.bairro, numero.value, data.cep, data.uf)
                        numero.style.borderColor = '#ccc';
                        errorNumero.textContent = '';
                    }
                })
            }else{
                document.querySelector('#cepInfos').style.display = 'flex';
                document.querySelector('#errorCidade').style.display = 'block';
                cepBtn.value = 'Verificar CEP';
                cepBtn.disabled = false;
                document.querySelector('#cadastrarBtn').disabled = true;
            }
        }else{
            errorMsg.style.display = 'block';
            errorMsg.textContent = 'Desculpe, não encontramos seu endereço, verifique se o CEP esta correto';
            document.querySelector('#cadastrarBtn').disabled = true;
            cepBtn.value = 'Verificar CEP';
            cepBtn.disabled = false;
        }
    })
    .catch(error => {console.log(error)});
})

function cadastrarEndereco(id, admin, cidade, rua, bairro, numero, cep, uf){
    const cadastroMsg = document.querySelector('#cadastroMsgm');

    fetch(`http://localhost/marketplace/cep/cadastrar.php?id=${id}&admin=${admin}&cidade=${cidade}&rua=${rua}&bairro=${bairro}&numero=${numero}&cep=${cep}&uf=${uf}`)
    .then(response => response.json())
    .then(data => {
        if(data.status = 'sucesso'){
            cadastroMsg.classList.add('show');
        }
    })

    setTimeout(() => {
        window.location.href = '../index.php';
    },2000)
}