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
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Rankings extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('Settings_model');
		$this->Settings_model->load();
		
		$top = $this->get_top(TRUE);
		$barometer = $this->get_top(FALSE);

		$this->load->view('main/index', array('top' => $top, 'barometer' => $barometer));

	}

	public function makepwd()
	{
		echo password_hash('nff35 leeuwarden admin', PASSWORD_BCRYPT);
	}

	public function xml()
	{
		$this->output->set_header('Content-type: text/xml');
		$top = $this->get_top(TRUE);
		$barometer = $this->get_top(FALSE);
		$this->load->view('main/top_xml_output', array('top' => $top, 'barometer' => $barometer));
	}

	//change to public to enable import functionality
	// private function import()
	// {
	// 	$f = file_get_contents('/Users/RidderGraniet/Sites/stemmenteller/lijst.csv');
	// 	$this->load->library('parsecsv', NULL, 'csv');
	// 	$this->csv->delimiter = ';';
	// 	$this->csv->input_encoding = "UTF-8";
	// 	$this->csv->parse($f);
	// 	//echo "<pre>".print_r($this->csv->data, true)."</pre>";

	// 	$this->load->model('Movies_model');

	// 	$movies = array();
	// 	$showings = array();

	// 	foreach($this->csv->data as $key => $entry)
	// 	{
	// 		//don't do this one if noentry is set
	// 		if(trim($entry['noentry']) == 'x')
	// 			continue;

	// 		//movie itself
	// 		if(strpos($entry['prize'], 'ja') !== FALSE)
	// 			$entry['movie_can_win'] = 1;
	// 		else
	// 			$entry['movie_can_win'] = 0;

	// 		$movie = array(
	// 			'movie_name' => $entry['Titel film'],
	// 			'movie_can_win' => $entry['movie_can_win']
	// 			);


	// 		if(!empty(trim($entry['Tijd1'])))
	// 		{
	// 			$date = explode('-', $entry['Datum1']);
	// 			$movie['movie_showings'][0]['showing_datetime'] = strtotime($date[2].'-'.$date[1].'-'.$date[0].' '.$entry['Tijd1']);
	// 		}

	// 		if(!empty(trim($entry['tijd2'])))
	// 		{
	// 			$movie['movie_showings'][1]['showing_datetime'] = strtotime($entry['datum2'].'-14 '.$entry['tijd2']);
	// 		}

	// 		if(!empty(trim($entry['tijd3'])))
	// 		{
	// 			$movie['movie_showings'][2]['showing_datetime'] = strtotime($entry['datum3'].'-14 '.$entry['tijd3']);
	// 		}

	// 		$this->Movies_model->insert($movie, FALSE);
	// 		echo "Inserted '".$movie['movie_name']."' into db. <br />";
	// 		//echo "<pre>".print_r($movie, true)."</pre>";

	// 	}
	// }

	private function get_top($only_can_win = TRUE)
	{
		$grades = array();
		$this->load->model('Movies_model');
		$this->load->model('Votings_model');
		$all_movies = $this->Movies_model->get(FALSE, $only_can_win);
		$i = 0;

		foreach($all_movies->result() as $movie)
		{
			$gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id);
			$grades[$i]['grade'] = $gradeinfo['grade'];
			$grades[$i]['movie_name'] = $movie->movie_name;
			$grades[$i]['totalvotes'] = $gradeinfo['totalvotes'];
			$i++;
		}

		usort($grades, function($a, $b) {
    		return $a['grade'] > $b['grade'] ? -1 : 1;
			});

		return array_slice($grades, 0, 5);
	}
}