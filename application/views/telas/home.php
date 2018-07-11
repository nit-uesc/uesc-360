<form data-abide action="<?php echo base_url('home/consulta'); ?>" id="myForm" method="post" onsubmit="return false;">
  <div class="input-field col s12 white card myform" style="margin: 0;">
    <div class="wrapper">
      <i class="material-icons">search</i>
      <input id="busca" type="search" placeholder="Pesquisa" autocomplete="off" name="busca" onkeyup="myFunction()" autofocus />
    </div>
  </div>
</form>

<div class="row" id="loading" style="display: none;">
  <div class="col s12 center">
    <div class="preloader-wrapper small active">
      <div class="spinner-layer spinner-blue-only">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="pesquisa">

     <!--menu filtro para consultas pessoa, laboratorio, equipamentos-->
     <div class="selecionar_pesquisa">

       <fieldset >
         <legend class="grey-text"> Pesquisar por </legend>
           <form action="<?php echo base_url('home/consulta'); ?>" id="myForm2" method="post" onsubmit="return false;" value="pessoas">

               <p>

                 <input type="checkbox" id="check_pes" onclick="myFunction()" checked="checked" value="laboratorio" />
                 <label for="check_pes">Pessoas</label>
               </p>

               <p>

                 <input type="checkbox" id="check_lab" checked="checked" onclick="myFunction()"/>
                 <label for="check_lab">Laboratorios</label>
               </p>

               <p>

                 <input type="checkbox" id="check_eq" checked="checked" onclick="myFunction()" value="equipamento"/>
                 <label for="check_eq">Equipamentos</label>
               </p>
           </form>
        </fieldset>
     </div>

     <!--Card com o retorno da pesquisa-->

    <div class="resultado_pesquisa" id="div_busca">
    </div>
</div>



<script>
  function MySubmit()
  {
    var params = $("#myForm").serialize()+'';
    var prms = params.split('=');
    var form = $("#myForm");

    $.ajax({
      type : "POST",
      url : form.attr("action"),
      /*Passa como parametros para o controller home a string digitada na busca e os check box que estão selecionados*/
      data : {busca:prms[1],checkboxs:getCheckBoxSelected()},
      success : function(response) {

        $('#div_busca').html(response);

      },

      beforeSend: function(){
      $('#loading').css({display:"block"});
      },
      complete: function(msg){
        $('#loading').css({display:"none"});
      }

    });

  }

function myFunction()
{

    MySubmit();

    if($('input#busca').val()==''){
        getTodosResultados();
    }
  }
</script>

<script>

/*Função usada para pegar os checkbox que estão selecionados*/
function getCheckBoxSelected()
{
    var idSelector = function() { return this.id; };
    var isChecked = [false, false, false];//Vetor usado para guarda quais checkbox estão marcados [0 - pessoa, 1 - laboratorio, 2 - equipamento] default deselect
    var checked = $(":checkbox:checked").map(idSelector).get()+ '' ;
    var checkbox = checked.split(',');

        //var noChe = $(":checkbox:not(:checked)").map(idSelector).get() ;
        for (i = 0; i < checkbox.length; i++) {
            if(checkbox[i] === 'check_pes'){

              isChecked[0] = true;
            }
            if(checkbox[i] === 'check_lab'){

              isChecked[1] = true;
            }
            if(checkbox[i] === 'check_eq'){

              isChecked[2] = true;
            }
        }
    return isChecked;
}

/*evento usado para iniciar a tabela com todos os valores[pessoas, equipamentos, laboratorios]*/
window.onload = function(){
      getTodosResultados();
}


/*função que retorna todos os dados de pessoa, laboratorio, equipamentos*/
function getTodosResultados(){
      var params = $("#myForm").serialize()+'';
      var prms = params.split('=');
      var form = $("#myForm");

      $.ajax({
        type : "POST",
        url : 'home/getResultados',
        /*Passa como parametros para o controller home a string digitada na busca e os check box que estão selecionados*/
        data : {busca:prms[1],checkboxs:getCheckBoxSelected()},
        success : function(response) {

          $('#div_busca').html(response);

        },

        beforeSend: function(){
        $('#loading').css({display:"block"});
        },
        complete: function(msg){
          $('#loading').css({display:"none"});
        }

      });
}

</script>
