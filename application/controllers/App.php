<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

defined('BASEPATH') OR exit('No direct script access allowed');
include_once("functions/image.func.php");
include_once("functions/string.func.php");

class App extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//kauth

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];

        $redirectlogin= "";
        if(!empty($this->session->userdata("adminuserid".$configvlxsessfolder)))
        {
        	$redirectlogin= $this->session->userdata("adminuserid".$configvlxsessfolder);
        }

        if(empty($redirectlogin))
		{
			redirect('login');
		}

		$this->adminuserid= $this->session->userdata("adminuserid".$configvlxsessfolder);
		$this->adminuserloginnama= $this->session->userdata("adminuserloginnama".$configvlxsessfolder);
		$this->adminusernama= $this->session->userdata("adminusernama".$configvlxsessfolder);
		$this->adminusergroupid= $this->session->userdata("adminusergroupid".$configvlxsessfolder);
		$this->adminuserpendidikan= $this->session->userdata("adminuserpendidikan".$configvlxsessfolder);
	}
	
	public function index()
	{
		$pg = $this->uri->segment(3, "home");

		$reqId = $this->input->get("reqId");
		$adminuserid= $this->adminuserid;
		// echo $adminuserid;exit;

		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);

		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("main/".$pg,$view,TRUE),
			'pg' => $pg
		);
		// print_r($view);exit;

		/*if($pg == "home")
		{
			$this->load->library('globalsatuankerja');

			$vgl= new globalsatuankerja();
			$arrtreesatuankerja= $vgl->getsatuankerjatree([]);
			$arrdatasatuankerja= $vgl->getsatuankerjadata([]);

			$this->session->set_userdata('sesstree'.$configvlxsessfolder, $arrtreesatuankerja);
			$_SESSION["sesstree"]= $arrtreesatuankerja;
			// print_r($_SESSION["sesstree"]);exit;

			$this->session->set_userdata('sessdatatree'.$configvlxsessfolder, $arrdatasatuankerja);
			$_SESSION["sessdatatree"]= $arrdatasatuankerja;
			// print_r($_SESSION["sessdatatree"]);exit;
		}*/
		
		$this->load->view('main/index', $data);
	}

	public function page()
	{
		$pg = $this->uri->segment(3, "home");

		$reqId = $this->input->get("reqId");
		$adminuserid= $this->adminuserid;
		// echo $adminuserid;exit;

		$view = array(
			'pg' => $pg,
			'linkBack' => $file."_detil"
		);

		$data = array(
			'breadcrumb' => $breadcrumb,
			'content' => $this->load->view("page/".$pg,$view,TRUE),
			'pg' => $pg
		);
		// print_r();exit;

		/*if($pg == "home")
		{
			$this->load->library('globalsatuankerja');

			$vgl= new globalsatuankerja();
			$arrtreesatuankerja= $vgl->getsatuankerjatree([]);
			$arrdatasatuankerja= $vgl->getsatuankerjadata([]);

			$this->session->set_userdata('sesstree'.$configvlxsessfolder, $arrtreesatuankerja);
			$_SESSION["sesstree"]= $arrtreesatuankerja;
			// print_r($_SESSION["sesstree"]);exit;

			$this->session->set_userdata('sessdatatree'.$configvlxsessfolder, $arrdatasatuankerja);
			$_SESSION["sessdatatree"]= $arrdatasatuankerja;
			// print_r($_SESSION["sessdatatree"]);exit;
		}*/
		
		$this->load->view('main/index', $data);
	}

	public function loadUrl()
	{		
		$reqFolder = $this->uri->segment(3, "");
		$reqFilename = $this->uri->segment(4, "");
		$reqParse1 = $this->uri->segment(5, "");
		$reqParse2 = $this->uri->segment(6, "");
		$reqParse3 = $this->uri->segment(7, "");
		$reqParse4 = $this->uri->segment(8, "");
		$reqParse5 = $this->uri->segment(9, "");
		$data = array(
			'reqParse1' => urldecode($reqParse1),
			'reqParse2' => urldecode($reqParse2),
			'reqParse3' => urldecode($reqParse3),
			'reqParse4' => urldecode($reqParse4),
			'reqParse5' => urldecode($reqParse5)
		);

		if($reqFolder == "main" || $reqFolder == "public" || $reqFolder == "admin")
			$this->session->set_userdata('currentUrl', $reqFilename);
		
		$this->load->view($reqFolder.'/'.$reqFilename, $data);
	}	
	
	public function logout()
	{
		$this->kauth->unsetcekuserloginpersonal();
		// $this->session->sess_destroy();
		redirect ('login');
	}
}