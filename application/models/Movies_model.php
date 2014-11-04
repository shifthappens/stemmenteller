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
 * @author  shifthappens <coen@shifthappens.nl>
 * @copyright   Copyright (c) 2014, shifthappens
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Movies_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($id = FALSE)
    {
        if($id === FALSE)
            return $this->db->select('*')->order_by('movie_name', 'asc')->get('movies');
        else
            return $this->db->get_where('movies', array('movie_id' => $id), 0, 1)->row();
    }

    public function insert($newmovie)
    {       
        $this->db->insert('movies', array('movie_name' => $newmovie['movie_name'], 'movie_can_win' => $newmovie['movie_can_win']));
        $insert_id = $this->db->insert_id();

        foreach($newmovie['movie_showings'] as $showing)
        {
            if($showing['date'] != "NULL")
            {
                $showing['movie_id'] = $insert_id;
                $showing['showing_datetime'] = strtotime($showing['date'].' '.$showing['hour'].':'.$showing['minutes']);
                log_message('debug', 'showing = '.print_r($showing, TRUE));
                $this->db->insert('showings', array('movie_id' => $showing['movie_id'], 'showing_datetime' => $showing['showing_datetime']));
            }
        }

        return TRUE;
    }

    public function update($moviedata)
    {
        $data = array(
            'movie_name' => $moviedata['movie_name'],
            'movie_can_win' => $moviedata['movie_can_win']
            );

        $this->db->where('movie_id', $moviedata['movie_id'])
                ->update('movies', $data);

        $this->load->model('Showings_model');
        $this->Showings_model->update($moviedata);

        return true;
    }

    public function get_showings_for_movie($movie_id)
    {
        return $this->db->select('*')->order_by('showing_datetime', 'asc')->where(array('movie_id' => $movie_id))->get('showings');
    }

}