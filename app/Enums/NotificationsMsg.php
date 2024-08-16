<?php

namespace App\Enums;

enum NotificationsMsg: string
{
  case PRODUCT_CREATED = 'Product created';
  case PRODUCT_DELETED = 'Product deleted';
  case PRODUCT_UPDATED = 'Product updated';
  case ORDER_CREATED = 'Order created';
}
