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
 * @package	NFF Stemmenteller
 * @author	Coen de Jong <coen@shifthappens.nl>
 * @copyright	Copyright (c) 2014, shifthappens. (http://shifthappens.nl/)
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Rankings extends CI_Controller {

	public function index()
	{
		$this->load->model('Settings_model');
		$this->Settings_model->load_settings();

		$this->load->helper('nff');
		check_time_based_actions();
		
		$top = $this->get_top(TRUE);
		$barometer = $this->get_top(FALSE, FALSE);

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


	private function get_top($only_can_win = TRUE, $only_enough_votes = TRUE)
	{
		$grades = array();
		$this->load->model('Movies_model');
		$this->load->model('Votings_model');
		$all_movies = $this->Movies_model->get(FALSE, $only_can_win);
		$i = 0;

		foreach($all_movies->result() as $movie)
		{
			$gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id);

			if($gradeinfo['totalvotes'] < $this->config->item('voting_minimum') && $only_enough_votes === TRUE)
				continue; //only keep those with the set amount of minimum votes

			$grades[$i]['grade'] = $gradeinfo['grade'];
			$grades[$i]['movie_name'] = $movie->movie_name;
			$grades[$i]['totalvotes'] = $gradeinfo['totalvotes'];
			$i++;
		}

		usort($grades, function($a, $b) {
    		return $a['grade'] > $b['grade'] ? -1 : 1;
			});

		if($this->config->item('show_ranking_status') == 'from4' && $only_can_win === TRUE)
			$offset = 3;
		else
			$offset = 0;

		return array_slice($grades, $offset, 5, TRUE);
	}
}