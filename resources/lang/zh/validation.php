<?php

return [
    'custom' => [
        'name' => [
            'required' => '必须填写真实姓名。',
            'max' => '超过最大长度 :max',
        ],
        'email' => [
            'required' => '必须填写电子邮件地址。',
            'email' => '无效的电子邮件地址。',
            'max' => '超过最大长度 :max',
            'unique' => '该电子邮件地址已经被使用',
        ],
        'password' => [
            'required' => '必须填写密码。',
            'min' => '长度必须大于 :min',
            'confirmed' => '两次输入的密码不一样。',
        ],
        'student' => [
            'required' => '必须填写学号。',
            'max' => '超过最大长度 :max',
        ],
        'major' => [
            'max' => '超过最大长度 :max',
        ]
    ]
];
