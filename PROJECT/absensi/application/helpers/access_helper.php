<?php 
function check_mapel_access($user_id, $mapel_id)
{
    $ci = get_instance();
    $ci->db->where('user_id', $user_id);
    $ci->db->where('mapel_id', $mapel_id);
    $result = $ci->db->get('user_access_mapel');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}


