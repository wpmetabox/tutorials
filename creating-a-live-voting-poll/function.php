add_action('wp_ajax_submit_poll_vote',        'submit_poll_vote');
add_action('wp_ajax_nopriv_submit_poll_vote', 'submit_poll_vote');

function submit_poll_vote() {
	$label = sanitize_text_field($_POST['option'] ?? '');
    $vote  = get_option('votes');
	
	if (empty($vote['options'])) {
        wp_send_json_error(['message' => 'No options found']);
    }
	
   $ip        = $_SERVER['REMOTE_ADDR'];
  $voted_ips = get_option('poll_voted_ips', []);
   if (in_array($ip, $voted_ips)) {
      wp_send_json_error(['message' => 'You have already voted!']);
    }

	$found = false;
    foreach ($vote['options'] as $i => $item) {
        if ($item['label'] === $label) {
            $vote['options'][$i]['votes'] = intval($item['votes']) + 1;
            $found = true;
            break;
        }
    }
	
	if (!$found) {
        wp_send_json_error(['message' => 'Option not found']);
    }
	$total = array_sum(array_column($vote['options'], 'votes'));
    foreach ($vote['options'] as $i => $item) {
        $vote['options'][$i]['percent'] = $total
            ? round($item['votes'] / $total * 100, 1)
            : 0;
    }
	
	update_option('votes', $vote);
	
    $voted_ips[] = $ip;
   update_option('poll_voted_ips', $voted_ips);
	
    usort($vote['options'], fn($a, $b) => $b['votes'] <=> $a['votes']);
    wp_send_json_success(['total' => $total, 'options' => $vote['options']]);
}
