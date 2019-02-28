<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'persian_month'        => ' :attribute ماه شمسی معتبر نیست.',
    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
//    'confirmed'            => 'The :attribute confirmation does not match.',
    'confirmed'            => ' :attribute ها باید بکسان باشند.',
//    'date'                 => 'The :attribute is not a valid date.',
    'date'                 => ' :attribute یک تاریخ معتبر نیست.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
//    'digits'               => 'The :attribute must be :digits digits.',
    'digits'               => ' :attribute باید :digits رقم باشد.',
    // 'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'digits_between'       => ' :attribute باید بین :min تا :max رقم باشد.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
//    'email'                => 'The :attribute must be a valid email address.',
    'email'                => ' :attribute باید یک ایمیل معتبر باشد.',
//    'exists'               => ' :attribute انتخاب شده در جدول :attribute ها موجود نیست..',
    'exists'               => ' :attribute انتخاب شده نامعتبر است.',
    // 'file'                 => 'The :attribute must be a file.',
    'file'                 => ' :attribute باید یک فایل باشد.',
    'filled'               => 'The :attribute field must have a value.',
    // 'image'                => 'The :attribute must be an image.',
    'image'                => ' :attribute باید عکس باشد.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
//    'integer'              => 'The :attribute must be an integer.',
    'integer'              => ' :attribute باید عددی باشد.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
//        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'file'    => ' :attribute نباید از :max کیلوبایت بیشتر باشد.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    // 'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimes'                => ' :attribute باید یکی از انواع فایل :values باشد.',
//    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => ':attribute باید فایلی از نوع : :values باشد.',
    'min'                  => [
//        'numeric' => 'The :attribute must be at least :min.',
        'numeric' => ' :attribute باید حداقل :min  باشد.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
//        'string'  => 'The :attribute must be at least :min characters.',
        'string'  => ' :attribute باید حداقل :min کاراکتر باشد.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    // 'numeric'              => 'The :attribute must be a number.',
    'numeric'              => ' :attribute باید عددی باشد.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
//    'required'             => 'The :attribute field is required.',
    'required'             => ':attribute الزامی است.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
//    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without'     => ' :attribute نیاز است وقتی :values وجود ندارد.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    // 'string'               => 'The :attribute must be a string.',
    'string'               => ' :attribute باید با حروف انگلیسی باشد.',
    'timezone'             => 'The :attribute must be a valid zone.',
//    'unique'               => 'The :attribute has already been taken.',
    'unique'               => ' :attribute قبلا ثبت شده و تکراری است..',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
////      Hotels
        'city_id' => 'نام شهر',
        'brand' => 'برند',
////      Posts
//        'title'             =>  'عنوان',
//        'body'              =>  'متن',
//        'abstract'          =>  'خلاصه',
//        'image'             =>  'تصویر',
//        'attachments[]'     =>  'پرونده',
//        'verification'      =>  'کد تایید عضویت',
////      Auth
//        'code_or_mobile'    =>  'شماره پرسنلی یا موبایل',
//        'password'          =>  'رمز عبور',
//        'mobile'            =>  'تلفن همراه',
////        Profile
        'name'              =>  'نام',
//        'family'            =>  'نام خانوادگی',
//        'code'              =>  'کد پرسنلی',
//        'type'              =>  'نوع',
//        'national_id'       =>  'کدملی',
//        'father_name'       =>  'نام پدر',
//        'birthplace'        =>  'محل تولد',
//        'issuance_place'    =>  'محل صدور',
//        'bc_id'             =>  'شماره شناسنامه',
//        'birthdate'         =>  'تاریخ تولد',
//        'region_id'         =>  'کد منطقه',
//        'gender'            =>  'جنسیت',
//        'degree'            =>  'مدرک تحصیلی',
//        'marital'           =>  'وضعیت تاهل',
//        'avatar'            =>  'عکس پرسنلی',
//        'tel'               =>  'تلفن ثابت',
//        'bank_account'      =>  'حساب بانکی',
//        'net_income'        =>  'خالص دریافتی',
//        'email'             =>  'ایمیل',
//        'login_at'          =>  'وارد شده در',
//        'remember_token'    =>  'توکن یادآوری',
//        'mobile_verified'   =>  'تایید موبایل',
//        'verification_code' =>  'کد تایید',
//        'address'           =>  'ادرس',
//
////        Regions
//        'id'                =>  'شناسه',
////        Profile Edit Password
//        'verification_code' =>  'کد تایید',
//
////        Generic fields
//        'created_at'        =>  'ساخته شده در',
//        'updated_at'        =>  'به روز شده در',
//        'deleted_at'        =>  'حذف شده در',
//
////        Importers
//        'import'            =>  'فایل درون ریز',
//
////        Bills
//        'user_code'         =>  'کد پرسنلی',
//        'fin_code'          =>  'کد مالی',
//        'payment'           =>  'مبلغ کسر',
//        'balance'           =>  'مانده کسر',
//
////        Forms
//        "max_pay"           =>  "سقف خدمات",
//
////        Financial Code
//        "description"       =>  "توضیح",
//
////        Reply
//        "reply_attachment"  =>  "فایل",
//
////        Invoice
//        "total_amount"      =>  "مقدار کل",
//        "bill_count"        =>  "تعداد اقساط",
//        "bill_amount"       =>  "مقدار قسط",
    ],

];