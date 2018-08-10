function refresh_div() {
    jQuery.ajax({
        url:'/TechChallenge/www/suporders.php',
        data: {$sql: "select t1.order_id, t2.name, t1.quantity, TIME_FORMAT(t1.time_ready, '%H:%i') as time_ready, CASE t1.paid_flag WHEN t1.paid_flag = 1 THEN 'Yes' ELSE 'No' END as paid	from orders as t1 join menu as t2 on t1.item_ref=t2.item_ref where order_completed=0"},
        type:'POST',
        success:function(results) {
            jQuery("#table-holder").load('ordertable.php');
        }
    });
}

t = setInterval(refresh_div,10000);