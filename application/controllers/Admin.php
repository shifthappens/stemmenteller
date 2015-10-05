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
 * @copyright	Copyright (c) 2014-2015, shifthappens
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->driver('session');
		$this->load->model('Settings_model');
		$this->Settings_model->load_settings();
		$this->load->helper(array('nff', 'url', 'form'));
		check_time_based_actions();
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
			$user = $this->Users_model->get($user);

			$this->session->set_userdata('user_name', $user->user_name);
			$this->session->set_userdata('user_level', $user->user_level);

			switch($this->session->userdata('user_level'))
			{
				//full admin rights (0 = highest)
				case '0':
				redirect('admin/dashboard', 'location');
				break;

				//just a manager / volunteer
				case '1':
				redirect('admin/votes', 'location');
			}
		}
	}

	public function dashboard()
	{
		security_check();

		$this->load->view('admin/dashboard');
	}

	public function settings()
	{
		security_check();

		log_message('debug', 'postdata = '.print_r($this->input->post(), true));
		$this->load->model('Settings_model');
		$file_upload_errors = FALSE;
		$message = FALSE;

		if($this->input->post('submit') == TRUE)
		{
			$settings = $this->input->post('settings');

			//File upload is optional, so we need to check if a file has been uploaded
			//if there is a file uploaded, run the upload sequence
			if(isset($_FILES['background_image']) && $_FILES['background_image']['size'] > 0)
			{
				$file_was_uploaded = TRUE;
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size']	= '2048'; //in kb
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('background_image'))
				{
					$upload_successful = FALSE;
					log_message('debug', 'upload error.');
					$file_upload_errors = $this->upload->display_errors();
					$this->load->view('admin/settings', array('upload_errors' => $file_upload_errors));
				}
				else
				{
					$upload_successful = TRUE;
					$file_data = $this->upload->data();

					$settings['background_image_url'] = $file_data['file_name'];
					$this->Settings_model->update($settings);
					$message = 'De instellingen zijn opgeslagen.';
					$this->load->view('admin/settings', array('message' => $message));
				}
			}
			else
			{
				//No file uploads
							
				$this->Settings_model->update($settings);
				$message = 'De instellingen zijn opgeslagen.';

				$this->load->view('admin/settings', array('message' => $message));
			}
		}
		else
		{
			$this->load->view('admin/settings');			
		}
	}

	public function movies()
	{
		security_check();

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
			log_message('debug', 'segment = '.$this->uri->segment(4));
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

			case 'delete':
			if($this->Movies_model->delete($this->uri->segment(4)))
			{
				$this->session->set_userdata('message', 'Verwijderen was succesvol.');
				$this->session->set_userdata('message-type', 'success');				
			}
			redirect('admin/movies', 'location');
			break;


			default:
			$this->load->model('Votings_model');
			$movies = $this->Movies_model->get();
			$this->load->view('admin/movies', array('movies' => $movies));
			break;
		}
	}

	public function votes()
	{
		security_check();

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

			case 'delete':
			if($this->Votings_model->delete($this->uri->segment(4)))
			{
				$this->session->set_userdata('message', 'Verwijderen was succesvol.');
				$this->session->set_userdata('message-type', 'success');				
			}
			redirect('admin/votes', 'location');
			break;

			default:
			$votings = $this->Votings_model->get();
			$this->load->view('admin/votes', array('votings' => $votings));
			break;
		}
	}

	public function export()
	{
		security_check();

		$this->load->model('Movies_model');
		$this->load->model('Votings_model');
		$this->load->helper('download');

		if($this->uri->segment(3) == 'csv')
		{
			if($this->uri->segment(4) == 'publieksprijs')
			{
				$movies = $this->Movies_model->get(FALSE, TRUE); //only can win
			}
			elseif($this->uri->segment(4) == 'barometer')
			{
				$movies = $this->Movies_model->get(FALSE, FALSE, TRUE); //only barometer
			}
			$csv = $this->load->view('admin/export-csv', array('movies' => $movies), TRUE);
			force_download('nff-export.csv', $csv);
		}
		else
		{
			$movies = $this->Movies_model->get(); //all
			$this->load->view('admin/export', array('movies' => $movies));			
		}
	}

	public function do_import()
	{
		//only use this function when the whole process was followed, from upload to verification
		if(!$this->session->userdata('import_mapped_headers'))
			redirect('admin/import');

		get_csv_file(); //helper function, saves it to $this->csv(->data)

		log_message('debug', 'mapped headers: '.print_r($this->session->userdata('import_mapped_headers'), TRUE));
		log_message('debug', 'number of movies to import: '.count($this->csv->data));

		$this->load->model('Movies_model');
		
		$movies = array();
		$showings = array();
		$mapped_headers = $this->session->userdata('import_mapped_headers');

		foreach($this->csv->data as $key => $entry)
	 	{
			//don't do this one if no_entry is set
			if(isset($mapped_headers['no_entry']))
			{
		 		if(trim($entry[$mapped_headers['no_entry']]) !== '')
					continue;
			}

	 		//movie itself
	 		if(trim($entry[$mapped_headers['movie_can_win']]) == 'ja' || trim($entry[$mapped_headers['movie_can_win']]) == 'x')
	 			$entry['movie_can_win'] = 1;
	 		else
	 			$entry['movie_can_win'] = 0;

	 		$movie = array(
	 			'movie_name' => $entry[$mapped_headers['movie_name']],
	 			'movie_can_win' => $entry['movie_can_win']
	 			);

	 		if(isset($mapped_headers['movie_showings_1_date']) && isset($mapped_headers['movie_showings_1_time']))
	 		{
		 		if(trim($entry[$mapped_headers['movie_showings_1_date']]) != '' && trim($entry[$mapped_headers['movie_showings_1_time']]) != '')
		 		{
		 			$date = explode('-', $entry[$mapped_headers['movie_showings_1_date']]);
		 			if(count($date) === 3)
		 			{
			 			$movie['movie_showings'][0]['showing_datetime'] = strtotime($date[2].'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_1_time']]);
			 		}
			 		elseif(count($date) === 2)
			 		{
			 			$movie['movie_showings'][0]['showing_datetime'] = strtotime(date('Y').'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_1_time']]);			 			
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 1e vertoonmoment. Jaar ontbrak in datum formaat, huidig jaar aangenomen (".date('Y').").";
			 		}
			 		else
			 		{
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 1e vertoonmoment. Datum is niet correct geformatteerd (dd-mm-yyyy). Dit vertoonmoment is overgeslagen.";
			 		}
		 		}
	 		}

	 		if(isset($mapped_headers['movie_showings_2_date']) && isset($mapped_headers['movie_showings_2_time']))
	 		{
		 		if(trim($entry[$mapped_headers['movie_showings_2_date']]) != '' && trim($entry[$mapped_headers['movie_showings_2_time']]) != '')
		 		{
		 			$date = explode('-', $entry[$mapped_headers['movie_showings_2_date']]);
		 			if(count($date) === 3)
		 			{
			 			$movie['movie_showings'][1]['showing_datetime'] = strtotime($date[2].'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_2_time']]);
			 		}
			 		elseif(count($date) === 2)
			 		{
			 			$movie['movie_showings'][1]['showing_datetime'] = strtotime(date('Y').'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_2_time']]);			 			
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 2e vertoonmoment. Jaar ontbrak in datum formaat, huidig jaar aangenomen (".date('Y').").";
			 		}
			 		else
			 		{
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 2e vertoonmoment. Datum is niet correct geformatteerd (dd-mm-yyyy). Dit vertoonmoment is overgeslagen.";
			 		}
		 		}	 			
	 		}
	 		
	 		if(isset($mapped_headers['movie_showings_3_date']) && isset($mapped_headers['movie_showings_3_time']))
	 		{
		 		if(trim($entry[$mapped_headers['movie_showings_3_date']]) != '' && trim($entry[$mapped_headers['movie_showings_3_time']]) != '')
		 		{
		 			$date = explode('-', $entry[$mapped_headers['movie_showings_3_date']]);
		 			if(count($date) === 3)
		 			{
			 			$movie['movie_showings'][2]['showing_datetime'] = strtotime($date[2].'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_3_time']]);
			 		}
			 		elseif(count($date) === 2)
			 		{
			 			$movie['movie_showings'][2]['showing_datetime'] = strtotime(date('Y').'-'.$date[1].'-'.$date[0].' '.$entry[$mapped_headers['movie_showings_3_time']]);			 			
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 3e vertoonmoment. Jaar ontbrak in datum formaat, huidig jaar aangenomen (".date('Y').").";
			 		}
			 		else
			 		{
			 			$errors[] = "Waarschuwing: Film '".$movie['movie_name']."' heeft een ongeldig 3e vertoonmoment. Datum is niet correct geformatteerd (dd-mm-yyyy). Dit vertoonmoment is overgeslagen.";
			 		}
		 		}	 			
	 		}

	 		$this->Movies_model->insert($movie, FALSE);
	 		$imported_movie_info[] = $movie;
	 	}

	 	$this->load->view('admin/import', array('imported_movies' => $imported_movie_info));
	}

	public function verify_import()
	{
		if(!$this->input->post('verify-submit'))
		{
			redirect('admin/import');
		}

		get_csv_file(); //saves it to $this->csv->data

		$csv_headers = $this->csv->titles;
		$mapped_headers = array();
		$columns = $this->input->post('csvverify-select');

		foreach($csv_headers as $key => $header_label)
		{
			if($this->input->post('csvverify-header['.$key.']') == 'NULL')
				continue;
			else
				$mapped_headers[$this->input->post('csvverify-header['.$key.']')] = $header_label;
		}

		log_message('debug', 'mapped headers: '.print_r($mapped_headers, TRUE));


		//check minimum amount of necessary mapped headers
		if(!array_key_exists('movie_name', $mapped_headers)
			|| !array_key_exists('movie_showings_1_date', $mapped_headers)
			|| !array_key_exists('movie_showings_1_time', $mapped_headers)
			|| !array_key_exists('movie_can_win', $mapped_headers))
		{
			$this->load->view('admin/import', array('errors' => 'Kon het CSV bestand niet inladen want een van de vereiste kolommen ontbrak. Minimaal de film naam, 1 vertoonmoment (datum en tijd) en of hij meedingt voor de prijs moeten bekend zijn.'));
			log_message('debug', 'Kon enkele kolommen niet vinden in de nieuwe headers');
		}
		else
		{
			$this->session->set_userdata('import_mapped_headers', $mapped_headers);
			redirect('admin/do_import');
		}
	}

	public function import()
	{
		security_check();

		if($this->input->post('upload_submit'))
		{
			//first upload the file
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'csv|txt';
			$config['max_size']	= '2048'; //in kb
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('import'))
			{
				$errors = $this->upload->display_errors();
				$this->load->view('admin/import', array('errors' => $errors));
			}
			else
			{
				//verify the headers
				$file_data = $this->upload->data();
				$this->session->set_userdata('import_filename', $file_data['file_name']);
				get_csv_file();
				
				$csv_headers = $this->csv->titles;
				$sample_data = array_slice($this->csv->data, 0, 5);
				$accepted_headers = array(
						'movie_name' => 'Filmtitel',
						'movie_showings_1_date' => 'Vertoonmoment 1 (Datum)',				
						'movie_showings_2_date' => 'Vertoonmoment 2 (Datum)',
						'movie_showings_3_date' => 'Vertoonmoment 3 (Datum)',
						'movie_showings_1_time' => 'Vertoonmoment 1 (Tijd)',				
						'movie_showings_2_time' => 'Vertoonmoment 2 (Tijd)',
						'movie_showings_3_time' => 'Vertoonmoment 3 (Tijd)',
						'movie_can_win' => 'Dingt mee voor prijs',
						'no_entry' => 'Film NIET invoeren'
					);
				
				$this->load->view('admin/import', array('csv_headers' => $csv_headers, 'sample_data' => $sample_data, 'accepted_headers' => $accepted_headers));
			}			
		}
		else
		{
			$this->load->view('admin/import');			
		}

	} 

	public function purge()
	{
		security_check();
		$this->load->model('Movies_model');
		$this->load->model('Votings_model');
		$this->load->model('Showings_model');

		$this->db->trans_begin();

		$this->Movies_model->delete_all();
		$this->Votings_model->delete_all();

		if($this->db->trans_status() === FALSE)
		{
			//error
			$this->db->trans_rollback();
			$this->session->set_flashdata('message', "Het verwijderen van alle films, vertoonmomenten en stemuitslagen kon niet worden voltooid. De oude gegevens zijn teruggezet, niets is verloren gegaan.");
			$this->session->set_flashdata('message-type', "warning");
		}
		else
		{
			//success
			$this->db->trans_commit();
			$this->session->set_flashdata('message', "Het verwijderen van alle films, vertoonmomenten en stemuitslagen is voltooid.");
			$this->session->set_flashdata('message-type', "success");
		}

		redirect('admin/settings');
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

function security_check()
{
	$ci =& get_instance();

	if(!$ci->session->userdata('loggedin'))
	redirect('admin');

	//user_level 1 = manager. May only manage votes and nothing else
	if($ci->session->userdata('user_level') == '1' && $ci->uri->segment(2) != 'votes' && $ci->uri->segment(2) != '')
		redirect('admin/votes');
}

function get_csv_file()
{
	$ci =& get_instance();
	if(!$ci->session->userdata('import_filename'))
	{
		return FALSE;
	}

	$f = file_get_contents('uploads/'.$ci->session->userdata('import_filename'));
	$f .= "\n"; //adding a newline to the file to make sure parsecsv lib also imports the last line in the file (bug)
	$ci->load->library('parsecsv', NULL, 'csv');
	$ci->csv->delimiter = ';';
	$ci->csv->input_encoding = "UTF-8";
	$ci->csv->parse($f);

	return TRUE;

}