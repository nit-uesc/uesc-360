<style>
.main-wrapper
{
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

</style>

<div class="valign-wrapper" id="login">

	<div class="row">
		<div class="col s12 m12 offset-m1">
			<ul class="collection with-header card">
				<li class="collection-header">
					<h4 class="white-text">Login</h4>
				</li>
				<li class="collection-item">
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
					<?php
					if(isset($sucesso)):
					  echo '<div class="green card-panel white-text">';
					  echo $sucesso;
					  echo '</div>';
					endif;
					?>
					<!-- The form it self -->
					<?php echo form_open('login'); ?>
						<?php if(isset($loginError)): echo '<small class="red-text">* Dados Inválidos!</small>'; endif; ?>
						<br>
						<div class="row">
							<div class="input-field col s12">
							<i class="material-icons prefix">person</i>
							<input id="icon_user" type="text" name="usuario" value="<?php echo set_value('usuario'); ?>" class="validate">
							<label for="icon_user">Email</label>
							<?php echo form_error('usuario'); ?>
						</div>
						<div class="input-field col s12">
							<i class="material-icons prefix">lock</i>
							<input id="icon_password" type="password" name="senha">
							<label for="icon_password">Senha</label>
							<?php echo form_error('senha'); ?>
						</div>
						<div class="row">
							<div class="col s12 m6 button_espaco">
								<button type="submit" class="btn waves-effect waves-light">
									ENTRAR
								</button>
							</div>
							<div class="col s12 m6">
								<button class="btn __high waves-effect waves-light">
									<a class="" href="<?php echo base_url('pessoa/'); ?>">
										CADASTRE-SE
									</a>
								</button>
							</div>
						</div>
						<a class="__center grey-text" href="<?php echo base_url('login/recuperar_senha'); ?>">Esqueceu a senha? Clique aqui.</a>
					</div>
					<?php echo form_close(); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
