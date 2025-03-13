const form = document.querySelector('#formulario');

form.addEventListener('submit', function(event){
    event.preventDefault();

    let formData = new FormData(this);

    fetch('./login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status == 'erro'){
            loginErro('Usuario ou senha incorretos')
        }else if(data.status == 'erro3'){
            loginErro('Preencha os campos corretamente');
        }else if(data.status == 'sucesso'){
            window.location.href = '../index.php';
        }
    })
    .catch(error => {
        console.log('error', error);
    })
})

function loginErro(erroData){
    const errorMsg = document.querySelector('#error');
    errorMsg.style.display = 'block';
    errorMsg.textContent = erroData;

    const inputs = document.querySelectorAll('.input');
    const labels = document.querySelectorAll('label');

    inputs.forEach((input, i) => {
        input.style.borderColor = 'red';
        labels[i].style.color = 'red';
    })
}