<?php
/**
 * @Desc
 * @author 42
 * @CreateTime 2020/2/19 下午 8:43
 *
 **/

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID = 1;

    const PAID = 2;

    const DELIVERED = 3;

    const PAID_BUT_OUT_OF_STOCK = 4;
}