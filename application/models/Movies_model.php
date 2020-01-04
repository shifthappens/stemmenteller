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

    public function get($id = FALSE, $only_can_win = FALSE, $only_barometer = FALSE)
    {
        $this->db->select('*');
        $this->db->order_by('movie_name', 'asc');
        
        if($id !== FALSE)
            return $this->db->where('movie_id', $id)->limit(1)->get('movies')->row();
        
        if($only_can_win === TRUE)
            $this->db->where('movie_can_win', '1');

        if($only_barometer === TRUE)
            $this->db->where('movie_can_win', '0');

        return $this->db->get('movies');
    }

    public function insert($newmovie, $parse_datetime = TRUE)
    {       
        $this->db->insert('movies', array('movie_name' => $newmovie['movie_name'], 'movie_can_win' => $newmovie['movie_can_win']));
        $insert_id = $this->db->insert_id();

        if(isset($newmovie['movie_showings']) && is_array($newmovie['movie_showings']))
        {
            foreach($newmovie['movie_showings'] as $showing)
            {
                if( (isset($showing['date']) && $showing['date'] != "NULL") || isset($showing['showing_datetime']))
                {
                    $timestamp = $parse_datetime === TRUE ? strtotime($showing['date'].' '.$showing['hour'].':'.$showing['minutes']) : $showing['showing_datetime'];
                    $showing['movie_id'] = $insert_id;
                    $this->db->insert('showings', array('movie_id' => $showing['movie_id'], 'showing_datetime' => $timestamp));
                }
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

    public function delete($movie_id)
    {
        $this->db->delete('showings', array('movie_id' => $movie_id));
        $this->db->delete('movies', array('movie_id' => $movie_id));
    }

    public function delete_all()
    {
        $this->db->empty_table('movies');
        $this->db->empty_table('showings');
    }

}