<?php
/* 
*	Template Name: Users Listing Page
*/
?>

<?php get_header(); ?>

<h1>List Users</h1>

<?php

$users = get_users(array(
    'meta_key'     => 'publish_account',
    'meta_value'   => 'yes',
));

?>
<table id="listUsers">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($users as $user) { $user_id = $user->ID; ?>
            <tr>
                <td><?php echo $user->display_name; ?></td>
                <td><?php echo rwmb_meta( 'position', array( 'object_type' => 'user' ), $user_id ); ?></td>
                <td><?php echo rwmb_meta( 'office', array( 'object_type' => 'user' ), $user_id ); ?></td>
                <td><?php echo rwmb_meta( 'age', array( 'object_type' => 'user' ), $user_id ); ?></td>
                <td><?php echo rwmb_meta( 'start_date', array( 'object_type' => 'user' ), $user_id ); ?></td>
                <td>$<?php echo number_format(rwmb_meta( 'salary', array( 'object_type' => 'user' ), $user_id ),3,",","."); ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
        </tr>
    </tfoot>
</table>

<?php get_footer(); ?>
