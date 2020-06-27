<?php if(empty($pavilhao)): ?>
  <div class="row"><div class="col s12 m8 offset-m2 l6 offset-l3 center lighten-4"><p class="flow-text">Oops... nenhum dado foi encontrado! :(</p></div></div>
<?php else: ?>

  <div class="row">
    <div class="col s12">
      <p class="grey-text flow-text">Editar dados de "<?php echo $pavilhao[0]->nome_pav; ?>"</p>
    </div>
  </div>
  <?php echo form_open('pavilhao/editar_pavilhao/'.$pavilhao[0]->id_pavilhao); ?>

    <div class="row">
        <div class="input-field col s9">
            <?php echo form_input(array('id' => 'inome', 'name' => 'nome'), set_value('nome', $pavilhao[0]->nome_pav)); ?>
            <label for="inome">Nome</label>
            <?php echo form_error('nome'); ?>
        </div>

        <div class="row">
            <div class="s12 col">
                <button type="submit" class="btn right blue"><i class="material-icons left">save</i>Salvar Dados</button>
            </div>
        </div>
    </div>

  <?php echo form_close(); ?>

<?php endif; ?>
