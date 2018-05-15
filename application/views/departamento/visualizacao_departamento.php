<!-- Mensagem de sucesso -->
<?php if ($this->session->flashdata('sucesso') != ''): ?>
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


<?php if (empty($departamento)): ?>
    <div class="row"><div class="col s12 m8 offset-m2 l6 offset-l3 center lighten-4"><p class="flow-text">Oops... nenhum dado foi encontrado! :(</p></div></div>
<?php else: ?>
    <div class="row">

        <div class="col s12 m10 l9">
            <div class="row">

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

                <div class="col s12">
                    <span class="flow-text grey-text">DEPARTAMENTO <span class="black-text"><?php echo $departamento[0]->nome_dpt; ?></span></span>
                    <br>
                    <br>
                </div>

                <!-- DADOS DO departamento -->
                <div id="dados_lab" class="section scrollspy col s12 center indigo">
                    <h5 class="white-text">Laboratório(s) do Departamento</h5>
                </div>

                <div class="col s12">
                    <?php if (empty($departamento_lab)): ?>
                        <div class="divider"></div>
                        <p>Não há laboratório vinculadas ao Departamento.</p>
                    <?php else: ?>
                        <div class="collection">
                            <?php foreach ($departamento_lab as $row): ?>
                                <a class="collection-item blue-text" href="<?php echo base_url('laboratorio/visualizar_laboratorio/' . $row->id_laboratorio); ?>" title="Clique para visualizar o Laboratório"><b><?php echo $row->nome_lab; ?></b></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
<?php endif; ?>
