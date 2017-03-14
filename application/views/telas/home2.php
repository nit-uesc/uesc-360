<div class="row" id="img-home">
  <div class="col s12 center">
    <p class="flow-text">Seja bem-vindo ao Portfólio Virtual de Competências da UESC!</p>
    <p>Pesquise por uma palavra chave ou apenas <a class="blue-text text-accent-2" href="<?php echo base_url('explore'); ?>">explore</a> a infraestrutura da UESC de maneira rápida e fácil!</p>
  </div>
</div>

<div class="row">
  <div class="col s12 m10 offset-m1 l8 offset-l2">

    <div id="search-home">

      <form data-abide action="<?php echo base_url('home/consulta'); ?>" id="myForm" method="post">
        <div class="row card-panel hoverable">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input id="busca" type="text" placeholder="" autocomplete="off" name="busca" autofocus />
            <label for="busca">Digite aqui o nome de uma pessoa, laboratório ou equipamento e pressione ENTER</label>
            <button class="btn blue" style="width: 100%;">Buscar</button>
          </div>
        </div>
      </form>

    </div>

  </div>
</div>

<div class="row" id="cards-info">
  <div class="col s12">
    <p class="flow-text center grey-text text-darken-2a">O UESC 360° é uma ação do <a href="http://nit.uesc.br/">Núcleo de Inovação Tecnológica</a> da UESC.</p>
  </div>
</div>