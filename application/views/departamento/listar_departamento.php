<!-- Mensagem de sucesso -->
<?php if($this->session->flashdata('sucesso') != ''): ?>
<div class="row">
  <div class="col s12 card-panel green white-text">
    <p><?php echo $this->session->flashdata('sucesso'); ?></p>
  </div>
</div>
<!-- Mensagem de erro -->
<?php elseif ($this->session->flashdata('erro') != ''): ?>
<div class="row">
  <div class="col s12 card-panel red white-text">
    <p><?php echo $this->session->flashdata('erro'); ?></p>
  </div>
</div>
<?php endif; ?>
<!-- fim feedback da ação ao usuário -->

<ul class="collection" id="quicksearch">
<?php foreach ($departamento as $row): ?>
  <li class="collection-item avatar">
    <i class="material-icons circle indigo">location_city</i>
    <span class="title"><b><a class="blue-text text-accent-2"><?php echo $row->nome_dpt; ?></a></b></span>
    <div class="col s12 center">
                    <!-- Confirmação deletar -->
                    <div id="deletar_departamento" class="modal">
                        <div class="modal-content red white-text left-align">
                            <h4 class="white-text">Deletar departamento</h4>
                            <p><b>Você tem certeza que deseja continuar?</b></p>
                            <p><b>Após concluir essa ação você não poderá recuperar os dados do departamento.</b></p>
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo base_url('departamento/deletar_departamento/' . $departamento[0]->id_departamento); ?>" class="btn red modal-action modal-close waves-effect waves-green">Tenho certeza!</a>
                        </div>
                    </div>
                    <a class="modal-trigger" href="#deletar_departamento">
                        <i class="material-icons right red-text">delete</i>
                    </a>
                    <a href="<?php echo base_url('departamento/editar_departamento/' . $departamento[0]->id_departamento); ?>" title="Clique para editar os dados">
                        <i class="material-icons right black-text">edit</i>
                    </a>
                </div>
  </li>
<?php endforeach; ?>
</ul>
