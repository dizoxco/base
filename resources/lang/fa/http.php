<?php

return  [
    // message for http status code 200
    'ok'            =>  'درخواست موفق شد.',

    // message for http status code 400
    'bad_request'   =>  'نحوه درخواست ناقص، فریم پیام درخواست نادرست یا مسیر درخواست گمراه کننده است.',

    // message for http status code 401
    'unauthorized'  =>  'درخواست انجام نشده است، زیرا اعتبار احراز هویت برای منبع هدف فاقد اعتبار است.',

    // message for http status code 403
    'forbidden'     =>  'کاربر ممکن است مجوزهای لازم برای دسترسی به این منبع را نداشته باشد.',

    // message for http status code 404
    'not_found'     =>  'سرور، منبعی برای هدف درخواست شده پیدا نکرده است.',

    // message for http status code 500
    'internal_err'  =>  'سرور با یک وضعیت غیر منتظره مواجه شد که مانع از انجام این درخواست شد.',
];
