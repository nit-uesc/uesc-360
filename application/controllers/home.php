<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('funcoes');
		$this->load->helper('form_helper');

	}

	public function index()
	{

		$this->load->model('generica_consulta_model');
		$data['pessoa'] = $this->generica_consulta_model->listar_pessoas();
		$data['laboratorio'] = $this->generica_consulta_model->listar_laboratorios();
		$data['equipamento'] = $this->generica_consulta_model->listar_equipamentos();
		$data['main'] = 'telas/home';
		$this->load->view('templates/template_home', $data);



	}

	public function consulta()
  {
		$data = $this -> input -> post(null, true);
		$check_filter = $data['checkboxs'];

		if ($data['busca'] != ''):
			$this->load->model('consulta_model');

			/*vetores auxiliares usado para passar o resultado para pesquisa*/
			$aux_pes = new ArrayObject();
			$aux_lab = new ArrayObject();
			$aux_equi = new ArrayObject();

			$result = $this->consulta_model->busca($data['busca']);
			$rsNumber = count($result);

			if($rsNumber > 0):


				foreach ($result as $row):
					switch ($row->type):
						case 'p':
						   $aux_pes[] =  $row;

						break;

						case 'l':
			         $aux_lab[] =  $row;
							 

						break;

						case 'e':
				       $aux_equi[] =  $row;

						break;

						default:
						break;
					endswitch;
				endforeach;

				//pega os tamanhos do vetor para montar a tabela de acordo com o que tiver mais linhas
				$tam_aux_lab = count ($aux_lab);
				$tam_aux_equi = count ($aux_equi);
				$tam_aux_pes = count ($aux_pes);

				if(($tam_aux_lab > $tam_aux_equi) && ($tam_aux_lab > $tam_aux_pes) ){
          //laboratorios apresenta maior numero
					$data['maior'] = $tam_aux_lab;


				}else if (($tam_aux_equi > $tam_aux_lab) && ($tam_aux_equi > $tam_aux_pes) ){
         //equipamentos apresenta maior numero
					$data['maior'] = $tam_aux_equi;


				}else{
				//pessoas apresenta maior numero
				  $data['maior'] = $tam_aux_pes;
				}
        /*Vetor auxiliar para passar os parametros de pesquisa*/
				$OpcaoPesquisa = array("Laboratorios", "Equipamentos", "Pessoas");

	  		$this->load->model('generica_consulta_model');
			  $data['pessoa'] = $aux_pes;
				$data['laboratorio'] = $aux_lab;
				$data['equipamento'] = $aux_equi;
				$data['opp'] = $OpcaoPesquisa;
				$data['check'] = $check_filter;
				$data['main'] = 'telas/explore';
				$this->load->view('telas/explore', $data);//chamo a tela de explore

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

		else:

		endif;
	}

	public function getResultados()
  {
		$data = $this -> input -> post(null, true);
		$check_filter = $data['checkboxs'];


			$this->load->model('consulta_model');

			/*vetores auxiliares usado para passar o resultado para pesquisa*/
			$aux_pes = new ArrayObject();
			$aux_lab = new ArrayObject();
			$aux_equi = new ArrayObject();

			$result = $this->consulta_model->buscaTodos();
			$rsNumber = count($result);


			if($rsNumber > 0):
			/*echo "<p>Resultados encontrados: <b>".$rsNumber."</b></p>"; //teg que mostra a quantidade de resultados encontrado*/

				foreach ($result as $row):
					switch ($row->type):
						case 'p':
						   $aux_pes[] =  $row;

						break;

						case 'l':
			         $aux_lab[] =  $row;

						break;

						case 'e':
				       $aux_equi[] =  $row;

						break;

						default:
						break;
					endswitch;
				endforeach;

				//pega os tamanhos do vetor para montar a tabela de acordo com o que tiver mais linhas
				$tam_aux_lab = count ($aux_lab);
				$tam_aux_equi = count ($aux_equi);
				$tam_aux_pes = count ($aux_pes);

				if(($tam_aux_lab > $tam_aux_equi) && ($tam_aux_lab > $tam_aux_pes) ){
          //laboratorios apresenta maior numero
					$data['maior'] = $tam_aux_lab;


				}else if (($tam_aux_equi > $tam_aux_lab) && ($tam_aux_equi > $tam_aux_pes) ){
         //equipamentos apresenta maior numero
					$data['maior'] = $tam_aux_equi;


				}else{
				//pessoas apresenta maior numero
				  $data['maior'] = $tam_aux_pes;
				}
        /*Vetor auxiliar para passar os parametros de pesquisa*/
				$OpcaoPesquisa = array("Laboratorios", "Equipamentos", "Pessoas");

	  		$this->load->model('generica_consulta_model');
			  $data['pessoa'] = $aux_pes;
				$data['laboratorio'] = $aux_lab;
				$data['equipamento'] = $aux_equi;
				$data['opp'] = $OpcaoPesquisa;
				$data['check'] = $check_filter;
				$data['main'] = 'telas/explore';
				$this->load->view('telas/explore', $data);//chamo a tela de explore

		endif;
	}



}
