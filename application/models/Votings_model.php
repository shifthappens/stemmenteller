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

class Votings_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($id = FALSE)
    {
        if($id === FALSE)
            return $this->db->select('votings.*, movies.movie_name, showings.showing_datetime')
                    ->join('movies', 'votings.movie_id = movies.movie_id', 'left')
                    ->join('showings', 'votings.showing_id = showings.showing_id', 'left')
                    ->order_by('voting_datetime', 'desc')
                    ->get('votings');
        else
            return $this->db->get_where('votings', array('votings_id' => $id), 0, 1)->row();
    }

    public function insert($newvoting)
    {   
        $grades_serialized = serialize($newvoting['vote_grade_value']);

        $this->db->insert('votings', array(
            'voting_datetime' => time(),
            'movie_id' => $newvoting['movie_id'], 
            'showing_id' => $newvoting['showing_id'], 
            'grades' => $grades_serialized,
            'num_visitors' => $newvoting['num_visitors'],
            'num_volunteers' => $newvoting['num_volunteers']
        ));
        $insert_id = $this->db->insert_id();

        return TRUE;
    }

    public function calculate_grade($movie_id)
    {
        $grades = $this->db->select('grades')->where('movie_id', $movie_id)->get('votings');

        log_message('debug', 'grades: '.$grades->num_rows());

        if($grades->num_rows() == 0)
            return array('grade' => "Onbekend", 'totalvotes' => 0);

        $totals = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);

        foreach($grades->result() as $grade)
        {
            $gradearray = unserialize($grade->grades);
            $totals[1] += $gradearray[1];
            $totals[2] += $gradearray[2];
            $totals[3] += $gradearray[3];
            $totals[4] += $gradearray[4];
            $totals[5] += $gradearray[5];
        }

        $totalvotes = $totals[1] + $totals[2] + $totals[3] + $totals[4] + $totals[5];
        $average = ($totals[1] * 1) + ($totals[2] * 2) + ($totals[3] * 3) + ($totals[4] * 4) + ($totals[5] * 5);
        log_message('debug', 'movie = '.$movie_id.', totalvotes = '.$totalvotes.', average = '.$average);

        /* If nobody voted in this screening, it can happen that the total votes cast is 0, causing a divide by zero warning */
        if($totalvotes == 0)
            $grade = "Onbekend";
        else 
            $grade = ($average / $totalvotes) * 2;
        
        $gradeinfo = array('grade' => $grade, 'totalvotes' => $totalvotes);

        return $gradeinfo;

    }

    public function delete($voting_id)
    {
        $this->db->delete('votings', array('voting_id' => $voting_id));
    }
}