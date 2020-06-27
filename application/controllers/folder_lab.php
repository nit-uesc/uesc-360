<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require __DIR__.'/vendor/autoload.php';



class Folder_lab extends CI_Controller
{

	public function __construct(){
		parent::__construct();

	}
	public function index()
	{
		ob_start();
  	//  $data['siswa'] = $this->siswa_model->view_row();
    $this->load->view('preview');
    $html = ob_get_contents();
    ob_end_clean();

    require_once('./assets/html2pdf/html2pdf.class.php');
    $pdf = new HTML2PDF('P','A4','en');
    $pdf->WriteHTML($html);
    $pdf->Output('uesc3.pdf', 'D');
	}

}
