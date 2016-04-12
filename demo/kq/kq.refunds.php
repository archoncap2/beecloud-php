<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>BeeCloud快钱退款查询示例</title>
</head>
<body>
<table border="1" align="center" cellspacing=0>
    <?php
    require_once("../../loader.php");

    $data = array();
    $appSecret = "c37d661d-7e61-49ea-96a5-68c34e83db3b";
    $data["app_id"] = "c37d661d-7e61-49ea-96a5-68c34e83db3b";
    $data["timestamp"] = time() * 1000;
    $data["app_sign"] = md5($data["app_id"] . $data["timestamp"] . $appSecret);
    $data["channel"] = "KUAIQIAN";
    $data["limit"] = 10;

    try {
        $result = $api->refunds($data);
        if ($result->result_code != 0 || $result->result_msg != "OK") {
            echo json_encode($result->err_detail);
            exit();
        }
        $refunds = $result->refunds;
        $str = "<tr><td>退款是否成功</td><td>退款创建时间</td><td>退款号</td><td>订单金额(分)</td><td>退款金额(分)</td><td>渠道类型</td><td>订单号</td><td>退款是否完成</td><td>订单标题</td></tr>";
        foreach($refunds as $list) {
            $result = $list->result ? "成功" : "失败";
            $create_time = $list->create_time ? date('Y-m-d H:i:s',$list->create_time/1000) : '';
            $finish = $list->finish ? "完成" : "未完成";
            $str .= "<tr><td>$result</td><td>$create_time</td><td>{$list->refund_no}</td><td>{$list->total_fee}</td>
            	<td>{$list->refund_fee}</td><td>{$list->sub_channel}</td><td>{$list->bill_no}</td><td>$finish</td><td>{$list->title}</td></tr>";
        }
        echo $str;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>
</table>
</body>
</html>