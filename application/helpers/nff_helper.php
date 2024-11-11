<?php

function check_time_based_actions()
{
    $ci = &get_instance();
    $config = $ci->config;
    $tz = 'Europe/Amsterdam';
    $compare = new DateTime(sprintf('%s-%s-%s %s:%s', $config->item('show_ranking_auto_limit_year'), $config->item('show_ranking_auto_limit_month'), $config->item('show_ranking_auto_limit_day'), $config->item('show_ranking_auto_limit_hour'), $config->item('show_ranking_auto_limit_minutes')), new DateTimeZone($tz));
    $current = new DateTime('now', new DateTimeZone($tz));
    
    if ($current->getTimestamp() >= $compare->getTimestamp()) {
        $ci->load->model('Settings_model');
        $ci->Settings_model->update(['show_ranking_status' => 'from4']);
        $ci->Settings_model->load_settings();
        log_message('debug', "The current time ({$current->format('Y-m-d H:i:s')}) is later than or equal to the comparison time ({$compare->format('Y-m-d H:i:s')}).");
    } else {
        log_message('debug', "The current time ({$current->format('Y-m-d H:i:s')}) is earlier than the comparison time ({$compare->format('Y-m-d H:i:s')}).");
    }
}