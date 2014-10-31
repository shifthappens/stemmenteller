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
		$this->load->view('admin/settings');
	}

	public function movies()
	{
		switch($this->uri->segment(3))
		{
			case 'add':
			$this->load->view('admin/movies-form');
			break;

			case 'edit':
			$this->load->view('admin/movies-form');
			break;

			default:
			$this->load->view('admin/movies');
			break;
		}
	}

	public function votes()
	{
		switch($this->uri->segment(3))
		{
			case 'add':
			$this->load->view('admin/votes-form');
			break;

			case 'edit':
			$this->load->view('admin/votes-form');
			break;

			default:
			$this->load->view('admin/votes');
			break;
		}
	}

	public function dopassword()
	{
		$pwd = password_hash('test', PASSWORD_BCRYPT);
		echo $pwd;
		var_dump(password_verify('test', $pwd));
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin', 'location');

	}
}