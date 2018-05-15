<div class="row">
    <div class="col s12">
        <h4 class="grey-text">Cadastro de departamento</h4>

        <?php if(isset($sucesso)): ?>
        <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2 center">
            <div class="card-panel green accent-4 white-text">
            <i class="material-icons small">done</i>
            <br>
            <span><?php echo $sucesso; ?></span>
            <br>
            <br>
            <a href="<?php echo base_url('departamento/cadastrar_departamento'); ?>" class="btn green darken-3">Efetuar novo cadastro</a>
            </div>
        </div>
        </div>

        <?php elseif (isset($erro)): ?>

        <div class="row">
        <div class="col s12 m10 offset-m1 l8 offset-l2 center">
            <div class="card-panel red accent-4 white-text">
            <i class="material-icons small">error_outline</i>
            <br>
            <span><?php echo $erro; ?></span>
            <br>
            <br>
            <a href="<?php echo base_url('departamento/cadastrar_departamento'); ?>" class="btn green darken-3">Tentar novamente</a>
            </div>
        </div>
        </div>

        <?php else: ?>

        <?php echo form_open('departamento/cadastrar_departamento'); ?>
            <div class="row">
                <div class="input-field col s9">
                <?php echo form_input(array('id' => 'inome', 'name' => 'nome'), set_value('nome'), 'autofocus'); ?>
                <label for="inome">Nome</label>
                <?php echo form_error('nome'); ?>
                </div>
            </div>

            <div class="row">
                <div class="s12 col">
                <button type="reset" class="btn left grey hide-on-small-only"><i class="material-icons left">clear</i>Limpar</button>
                <button type="submit" class="btn right blue"><i class="material-icons left">save</i>Salvar Dados</button>
                </div>
            </div>

        <?php echo form_close(); ?>
        <?php endif; ?>

    </div>
</div>