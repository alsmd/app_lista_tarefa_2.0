function editar(id,src){
    //form
    let form = document.createElement("form");
    form.className = 'row';
    form.action = "php/controller.php?acao=atualizar&&src="+src;
    form.method = "post";
    //input
    let input = document.createElement("input");
    input.type = 'text';
    input.name = 'tarefa';
    input.className = 'form-control col-9';
    input.id = 'tarefa';

    //armazenando id da tarefa
    let input_id = document.createElement("input");
    input_id.type = 'hidden';
    input_id.name = 'id';
    input_id.value = id;
    //button
    let button = document.createElement("button");
    button.className = "btn btn-success col-3";
    button.type = 'submit';
    button.innerHTML = 'Atualizar';
    //conectar
    form.appendChild(input);
    form.appendChild(input_id);
    form.appendChild(button);

    //selecionar tarefa 
    tarefa = document.getElementById(id);
    input_tarefa = document.getElementById("tarefa");
    conteudo = tarefa.textContent != 'Atualizar'? tarefa.textContent : input_tarefa.value;
    console.log(conteudo);
    input.value = conteudo;
    tarefa.innerHTML = '';
    tarefa.insertBefore(form,tarefa[0]);
}

