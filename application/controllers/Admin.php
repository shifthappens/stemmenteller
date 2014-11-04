<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package StemmenTeller
 * @author	shifthappens <coen@shifthappens.nl>
 * @copyright	Copyright (c) 2014, shifthappens
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->driver('session');
		$this->load->model('Settings_model');
		$this->Settings_model->load();
	}

	public function index()
	{
		//already logged in?
		if($this->session->userdata('loggedin'))
			redirect('admin/dashboard', 'location');

		$this->load->view('admin/index');
	}

	public function login()
	{
		//already logged in?
		if($this->session->userdata('loggedin'))
			redirect('admin/dashboard', 'location');

		//shady business?
		if(!$this->input->post('username'))
			redirect('admin/index');

		//check log in details
		$user = $this->input->post('username');
		$pwd = $this->input->post('password');

		$this->load->model('Users_model');

		if(!$this->Users_model->check_credentials($user, $pwd))
		{
			$error = "Gebruikersnaam of wachtwoord onjuist.";
			$this->load->view('admin/index', array('message' => array('type' => 'danger', 'text' => $error)));
		}
		else
		{
			$this->session->set_userdata('loggedin', TRUE);
			redirect('admin/dashboard', 'location');
		}
	}

	public function dashboard()
	{
		$this->load->view('admin/dashboard');
	}

	public function settings()
	{
		log_message('debug', 'postdata = '.print_r($this->input->post(), true));
		$this->load->model('Settings_model');

		if($this->input->post('submit') == TRUE)
		{
			log_message('debug', 'settings submit exists');
			$this->Settings_model->update($this->input->post('settings'));
		}
		$this->load->view('admin/settings');
	}

	public function movies()
	{
		$this->load->model('Movies_model');
		$this->load->library('form_validation');
		$this->load->helper('form');

		switch($this->uri->segment(3))
		{
			case 'add':
			if($this->input->post('submit') !== NULL)
			{
				//we have a new movie to add

				//check the input
				$this->form_validation->set_rules('movie_name', 'Film Titel', 'required');
				$this->form_validation->set_rules('movie_can_win', 'Dingt mee voor de prijs', 'required');

				if($this->form_validation->run() === TRUE)
				{
					$postdata = $this->input->post();

					log_message('debug', 'postdata = '.print_r($postdata, TRUE));

					if($this->Movies_model->insert($postdata) === TRUE)
					{
						$this->session->set_userdata('message', 'Toevoegen was succesvol.');
						$this->session->set_userdata('message-type', 'success');
					}
					else
					{
						$this->session->set_userdata('message', 'Toevoegen ging niet goed.');
						$this->session->set_userdata('message-type', 'danger');						
					}
				}
			}

			$this->load->view('admin/movies-form');
			break;

			case 'edit':
			$this->load->model('Showings_model');
			$movie = $this->Movies_model->get($this->uri->segment(4));
			$showing = $this->Showings_model->get_by_movie($this->uri->segment(4));

			if($this->input->post('submit') !== FALSE)
			{
				//update an existing entry.
				$this->form_validation->set_rules('movie_name', 'Film Titel', 'required');
				$this->form_validation->set_rules('movie_can_win', 'Dingt mee voor de prijs', 'required');

				if($this->form_validation->run() === TRUE)
				{
					$postdata = $this->input->post();

					log_message('debug', 'postdata = '.print_r($postdata, TRUE));

					if($this->Movies_model->update($postdata) === TRUE)
					{
						$this->session->set_userdata('message', 'Aanpassen was succesvol.');
						$this->session->set_userdata('message-type', 'success');
					}
					else
					{
						$this->session->set_userdata('message', 'Aanpassen ging niet goed.');
						$this->session->set_userdata('message-type', 'danger');						
					}
				}

			}

			$this->load->view('admin/movies-form', array('movie' => $movie, 'showing' => $this->Showings_model->transform_to_array($showing)));
			break;

			default:
			$movies = $this->Movies_model->get();
			$this->load->view('admin/movies', array('movies' => $movies));
			break;
		}
	}

	public function votes()
	{
		$this->load->model('Movies_model');
		$this->load->model('Votings_model');
		$this->load->library('form_validation');
		$this->load->helper('form');

		switch($this->uri->segment(3))
		{
			case 'add':
			$movies = $this->Movies_model->get();
			if($this->input->post('submit') !== NULL)
			{
				//we have a new voting to add
				$postdata = $this->input->post();

				log_message('debug', 'postdata = '.print_r($postdata, TRUE));

				//check the input
				$this->form_validation->set_rules('movie_id', 'Film', 'required', array('required' => 'Kies een film!'));
				$this->form_validation->set_rules('showing_id', 'Vertoonmoment', 'required', array('required' => 'Kies een Vertoonmoment!'));

				if($this->form_validation->run() === TRUE)
				{
					if($this->Votings_model->insert($postdata) === TRUE)
					{
						$this->session->set_userdata('message', 'Toevoegen was succesvol.');
						$this->session->set_userdata('message-type', 'success');
					}
					else
					{
						$this->session->set_userdata('message', 'Toevoegen ging niet goed.');
						$this->session->set_userdata('message-type', 'danger');						
					}
				}
			}

			$this->load->view('admin/votes-form', array('movies' => $movies));

			break;

			case 'edit':
			$this->load->view('admin/votes-form', array('movies' => $movies));
			break;

			default:
			$votings = $this->Votings_model->get();
			$this->load->view('admin/votes', array('votings' => $votings));
			break;
		}
	}

	// public function dopassword()
	// {
	// 	$pwd = password_hash('test', PASSWORD_BCRYPT);
	// 	echo $pwd;
	// 	var_dump(password_verify('test', $pwd));
	// }

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin', 'location');

	}

	//AJAX functions
	public function ajax_get_showings_for_movie()
	{
		$this->load->model('Movies_model');
		
		$this->load->view('admin/ajax-get-showings-response', 
			array('response' => $this->Movies_model->get_showings_for_movie($this->input->post('movie_id'))));
	}
}

function date_match($timestamp, $datestring)
{
	if(empty($timestamp))
		return false;

	log_message('debug', 'timestamp = '.$timestamp.' ('.date('Y-m-d', $timestamp).') & datestring = '.$datestring);

	if(date('Y-m-d', $timestamp) == $datestring)
		return true;
	else
		return false;
}