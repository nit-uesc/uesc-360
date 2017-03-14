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
		$dados['main'] = 'telas/home';
		$this->load->view('templates/template_home', $dados);
	}

	public function consulta()
	{
		$data = $this -> input -> post(null, true);

		if ($data['busca'] != ''):
			$this->load->model('consulta_model');

			$result = $this->consulta_model->busca($data['busca']);
			$rsNumber = count($result);

			if($rsNumber > 0):
				echo "<p>Resultados encontrados: <b>".$rsNumber."</b></p>";
				foreach ($result as $row):
					switch ($row->type):
						case 'p':
	                        $link = base_url() . 'search/pessoa/'.$row->id.'/';
							echo "<div class='card-panel'>";
							echo "<span class='grey-text text-darken-1 right'>Pessoa</span> <br> <div class='divider grey lighten-1'></div>";
							echo "<br><a class='flow-text' target='_blank' href='{$link}'>{$row->name}</a> <br>";
							echo "<span><strong>Email: </strong>{$row->info1}</span><br>";
							echo "<span><strong>Lattes: </strong><a target='_blank' href='{$row->info2}'>{$row->info2}</a></span><br>";
							if(!empty($row->info3)):
								echo "<span><strong>Website: </strong>{$row->info3}</span>";
							endif;
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
		endif;

		// $dados['main'] = 'telas/home2';
		// $this->load->view('templates/template_home', $dados);
		// $this->load->view('templates/template_home');
	}
}