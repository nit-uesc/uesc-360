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
<?php foreach ($pavilhao as $row): ?>
  <li class="collection-item avatar">
    <i class="material-icons circle indigo">location_city</i>
    <span class="title"><b><a href="<?php echo base_url('pavilhao/visualizar_pavilhao/'.$row->id_pavilhao); ?>" title="Clique para visualizar o pavilhao" class="blue-text text-accent-2"><?php echo $row->nome_pav; ?></a></b></span>
    
    <a href="<?php echo base_url('pavilhao/visualizar_pavilhao/'.$row->id_pavilhao); ?>" target="_blank" title="Clique para visualizar o pavilhao em uma nova janela" class="secondary-content"><i class="material-icons blue-text text-accent-2">open_in_new</i></a>
  </li>
<?php endforeach; ?>
</ul>
