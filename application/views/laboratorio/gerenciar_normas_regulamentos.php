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


<?php if (empty($laboratorio)): ?>
    <div class="row"><div class="col s12 m8 offset-m2 l6 offset-l3 center lighten-4"><p class="flow-text">Oops... nenhum dado foi encontrado! :(</p></div></div>
<?php else: ?>

    <p class="flow-text grey-text">Adicionar Normas e Regulamentos "<span class="black-text"><?php echo $laboratorio[0]->nome_lab; ?></span>"</p>
    <div class="divider"></div>

    <br>
    <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2 card-panel">

            <?php if (isset($error)): ?>
                <div class="row">
                    <div class="col s12 red white-text card-panel">
                        <?php print_r($error); ?>
                    </div>
                </div>
            <?php endif; ?>


            <?php echo form_open_multipart('laboratorio/gerenciar_normas_regulamentos_laboratorio/' . $this->uri->segment(3)); ?>

            <div class="row">
                <div class="input-field col s12">
                    <?php echo form_input(array('id' => 'iregulamento', 'name' => 'regulamento'), set_value('regulamento'), 'autofocus'); ?>
                    <label for="inome">Informe o nome do regulamento</label>
                    <?php echo form_error('regulamento'); ?>
                </div>
            </div>


            <div class="file-field input-field">
                <div class="btn blue">
                    <span>Selecionar</span>
                    <input type="file" name="userfile">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" name="arquivo" placeholder="Clique para selecionar o PDF com regulamento">
                </div>
                <?php echo form_error('arquivo'); ?>
                <br>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="descricaoTextarea">Escreva uma descrição sobre o documento</label>
                    <textarea class="form-control" name="textareaDescricao" rows="3"></textarea>

                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <button type="button" class="btn right blue" onclick=""> <i class="material-icons left">save</i>Salvar Documento</button>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>

    <p class="flow-text grey-text">Normas e Regulamentos Salvos</span></p>
    <div class="divider"></div>
    <br>

    <div class="row">
        <div class="col s12">
            <?php if (empty($laboratorio_reg)): ?>
                <p>Não há documentos vinculadas ao laboratório. :(</p>
            <?php else: ?>

                <?php foreach ($laboratorio_reg as $row): ?>

                    <div class="row">
                        <div class="col s8">
                            <a target="_blank" href="<?php echo site_url('uploads/normas_regulamentos/' . $row->nome_reg_lab) ?>">

                                <i class="material-icons">&#xE415;</i><?php echo $row->nome_reg_infor; ?>

                            </a>
                        </div>
                        <div class="col s4">
                            <a class="modal-trigger btn-flat waves-effect red-text" href="#rmi<?php echo $row->id_reg_lab; ?>">
                                <i class="material-icons left">delete</i> Remover
                            </a>
                        </div>
                    </div>
                    <div class="collapsible"></div>

                    <!-- Confirmação deletar -->
                    <div id="rmi<?php echo $row->id_reg_lab; ?>" class="modal">
                        <div class="modal-content red white-text left-align">
                            <h4 class="white-text">Remover Documento</h4>
                            <p><b>Você tem certeza que deseja continuar?</b></p>
                            <p><b>Após concluir essa ação você não poderá recuperar o documento.</b></p>
                        </div>
                        <div class="modal-footer">

                            <a href="<?php echo base_url('laboratorio/del_norma_regulamento_laboratorio/' . $laboratorio[0]->id_laboratorio . '/' . $row->id_reg_lab); ?>" class="btn red modal-action modal-close waves-effect waves-green">Tenho certeza!</a>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
    </div>

<?php endif; ?>
