<?php

function check_time_based_actions()
{
    $ci =& get_instance();
    $timestamp = strtotime($ci->config->item('show_ranking_auto_limit_year')."-".
                 $ci->config->item('show_ranking_auto_limit_month')."-".
                 $ci->config->item('show_ranking_auto_limit_day')." ".
                 $ci->config->item('show_ranking_auto_limit_hour').":".
                 $ci->config->item('show_ranking_auto_limit_minutes'));

    log_message('debug', 'timestamp = '.$timestamp);

    if($timestamp <= time())
    {
        $ci->load->model('Settings_model');
        $ci->Settings_model->update(array('show_ranking_status' => 'from4'));
        $ci->Settings_model->load();
    }
}