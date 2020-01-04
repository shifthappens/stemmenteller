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

class Showings_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_movie($movie_id)
    {
        return $this->db->select('*')
                    ->where('movie_id', $movie_id)
                    ->get('showings');
    }

    public function insert($newshowing)
    {   
        $this->db->insert('showings', array(
            'movie_id' => $newshowing['movie_id'],
            'showing_datetime' => $newshowing['showing_datetime']
        ));
        $insert_id = $this->db->insert_id();

        return TRUE;
    }

    public function update($moviedata)
    {
        //delete then add again...
        $this->db->delete('showings', array('movie_id' => $moviedata['movie_id']));

        //add again
        foreach($moviedata['movie_showings'] as $showing)
        {
            if($showing['date'] != 'NULL' && $showing['date'] != '')
            { 
                $data = array(
                    'movie_id' => $moviedata['movie_id'],
                    'showing_datetime' => strtotime($showing['date'].' '.$showing['hour'].':'.$showing['minutes'])
                    );

                $this->insert($data);
            }
        }
    }

    public function transform_to_array($result)
    {
        $combined = array();
        $i = 0;

        foreach($result->result_array() as $row)
        {
            $combined[$i] = $row;
            $i++;
        }

        return $combined;
    }

    public function delete_all()
    {
        $this->db->empty_table('showings');
    }
}