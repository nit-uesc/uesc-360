<div class="row">
  <div class="col s12 m10 offset-m1 l8 offset-l2">

    <!-- <div id="search-home"> -->

      <form data-abide action="<?php echo base_url('home/consulta'); ?>" id="myForm" method="post">
        <div class="row card-panel hoverable">
          <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input id="busca" type="text" placeholder="" autocomplete="off" name="busca" onkeyup="myFunction()" autofocus />
            <label for="busca">Digite aqui o nome de uma pessoa, laboratório ou equipamento e pressione ENTER</label>
            <button class="btn blue" style="width: 100%;">Buscar</button>
          </div>
        </div>
      </form>

    <!-- </div> -->

    <?php
      if(isset($result) && count($result) > 0):
        foreach ($result as $row):

          switch ($row->type):
            case 'p':
              $link = base_url() . 'search/pessoa/'.$row->id.'/';
              echo "<div class='card-panel'>";
              echo "<span class='grey-text text-darken-1 right'>Pessoa</span> <br> <div class='divider grey lighten-1'></div>";
              echo "<br><a class='flow-text' target='_blank' href='{$link}'>{$row->name}</a> <br>";
              echo "<span><strong>Email: </strong>{$row->info1}</span><br>";
              echo "<span><strong>Lattes: </strong><a target='_blank' href='{$row->info2}'>{$row->info2}</a></span><br>";
              echo "<span><strong>Website: </strong>{$row->info3}</span>";
              echo "</div>";
            break;

            case 'l':
              $link = base_url() . 'search/laboratorio/'.$row->id.'/';
              echo "<div class='card-panel'>";
              echo "<span class='grey-text text-darken-1 right'>Laboratório</span> <br> <div class='divider grey lighten-1'></div>";
              echo "<br><a class='flow-text' target='_blank' href='{$link}'>{$row->name}</a> <br>";
              echo "<span><strong>Descrição:</strong> {$row->info1}</span><br>";
              echo "<span><strong>Atividades:</strong> {$row->info2}</span><br>";
              echo "<span><strong>Áreas atendidas: </strong>{$row->info3}</span>";
              echo "</div>";
            break;

            case 'e':
              $link = base_url() . 'search/equipamento/'.$row->id.'/';
              echo "<div class='card-panel'>";
              echo "<span class='grey-text text-darken-1 right'>Equipamento</span> <br> <div class='divider grey lighten-1'></div>";
              echo "<br><a class='flow-text' target='_blank' href='{$link}'>{$row->name}</a> <br>";
              echo "<span><strong>Descrição:</strong> {$row->info1}</span><br>";
              echo "<span><strong>Especificação:</strong> {$row->info2}</span><br>";
              echo "<span><strong>Fabricante: </strong>{$row->info3}</span>";
              echo "</div>";
            break;

            default:
            break;
          endswitch;
        endforeach;
      else:
        echo"
            <div class='row'>
              <div class='col s12 center'>
                <br>
                <i class='material-icons grey-text text-darken-1 medium'>report</i>
                <p class='flow-text grey-text text-darken-1'>Nenhum resultado encontrado</p>
              </div>
            </div>
          ";
      endif;
    ?>

  </div>
</div>