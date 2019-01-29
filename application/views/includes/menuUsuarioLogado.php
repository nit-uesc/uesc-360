<div class="indigo darken-2">
  <div class="right-align">
  <?php if (!$this->session->userdata('logged_in')): ?>
	<span class="left btn-flat white-text hide-on-small-only">Seja bem-vindo ao UESC 360º!</span>
  <?php elseif($this->session->userdata('logged_in')): ?>
	<a href="<?php echo base_url('login'); ?>" class="left white-text btn-flat hide-on-small-only">Olá,<?php foreach ($this->security_model->getPermissions() as $row): ?>
		  <?php if($row->fk_id_permissao == 1): ?>
			Administrador(a)
		  <?php elseif($row->fk_id_permissao == 2): ?>
			Coordenador(a)
		  <?php endif; ?>
		<?php endforeach; ?>
		 <?php echo $this->session->userdata('username'); ?>!</a>
  <?php endif; ?>
	<?php if (!$this->session->userdata('logged_in')): ?>
	  <a href="<?php echo base_url('pessoa'); ?>" class="white-text btn-flat"><i class="material-icons left">assignment</i> Cadastre-se</a>
	  <a href="<?php echo base_url('login'); ?>" class="white-text btn-flat"><i class="material-icons left">lock</i>Login</a>
	<?php elseif($this->session->userdata('logged_in')): ?>
	  <a class="dropdown-button btn-flat white-text" href="<?php echo base_url('login'); ?>" data-activates="dropdown1"><i class="material-icons left">account_circle</i>Área Restrita</a>

	  
	  <a href="<?php echo base_url('login/logoff'); ?>" class="white-text btn-flat"><i class="material-icons left">power_settings_new</i>Sair</a>
	<?php endif; ?>

  </div>
</div>
