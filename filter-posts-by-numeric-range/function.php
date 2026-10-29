<?php
function mb_get_max_range() {
    global $wpdb;
    $max = $wpdb->get_var("
        SELECT MAX(CAST(meta_value AS UNSIGNED))
        FROM {$wpdb->postmeta}
        WHERE meta_key = 'duration'
    ");
    return $max ? (int) $max : 0;
}

add_action('restrict_manage_posts', function($post_type) {
	if ($post_type !== 'class') return;
    $max = mb_get_max_range();
    if (!$max) return;
    $current = isset($_GET['range_max']) ? (int) $_GET['range_max'] : $max;
    ?>
	
	<div class="mb-range-filter">
        <label>
            Duration ≤ <strong><span id="range-value"><?php echo $current; ?></span></strong>
        </label>
        <input 
            type="range"
            id="range-slider"
            min="0"
            max="<?php echo $max; ?>"
            value="<?php echo $current; ?>"
        >
        <input type="hidden" name="range_max" value="<?php echo $current; ?>">
    </div>
	<?php
});

add_action('admin_head', function() {
    $screen = get_current_screen();
    if ($screen->post_type !== 'class') return;
?>
<style>
.mb-range-filter {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 8px;
    vertical-align: middle;
}

.mb-range-filter label {
    margin: 0;
    font-weight: 500;
}

#range-slider {
    width: 140px;
}
</style>
<?php
});

add_action('admin_footer-edit.php', function() {
    $screen = get_current_screen();
    if ($screen->post_type !== 'class') return;
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('range-slider');
    if (!slider) return;

    const display = document.getElementById('range-value');
    const hidden  = document.querySelector('[name="range_max"]');
    const form    = slider.closest('form');

    let timer;

    slider.addEventListener('input', () => {
        display.textContent = slider.value;
        hidden.value = slider.value;

        clearTimeout(timer);
        timer = setTimeout(() => form.submit(), 300);
    });
});
</script>
<?php
});

add_action('pre_get_posts', function($q) {
    if (!is_admin() || !$q->is_main_query()) return;
    if ($q->get('post_type') !== 'class') return;
    if (!isset($_GET['range_max'])) return;
	
    $max = (int) $_GET['range_max'];
    $q->set('meta_query', [[
        'key'     => 'duration',
        'value'   => [0, $max],
        'compare' => 'BETWEEN',
        'type'    => 'NUMERIC'
    ]]);
});
