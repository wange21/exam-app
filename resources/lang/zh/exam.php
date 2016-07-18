<?php

return [
    'running' => '进行中',
    'pending' => '未开始',
    'ended' => '已结束',

    'login' => [
        'title' => '登录 - ',
        'stuid' => '学号',
        'teacher' => '老师：',
        'pending' => '离考试开始',
        'running' => '离考试结束',
        'ended' => '考试已经结束',
        'hint' => [
            'import' => '本场考试需要您使用老师发放的账号进行登录。具体账号请从您的老师处获取。',
            'password' => '本场考试需要您登录考试系统，并且输入公共密码。具体密码请从您的老师处获取。',
        ]
    ],

    'auth' => [
        'failed' => '账号与密码不相符，如有疑问可以咨询您的老师。',
        'password' => '密码错误，如有疑问可以咨询您的老师。',
    ],

    'list' => [
        'title' => '考试列表',
        'header' => '考试列表',
        'all' => '全部',
        'running' => '进行中',
        'pending' => '未开始',
        'ended' => '已结束',
        'start' => '开始时间：',
        'duration' => '持续时间：',
        'teacher' => '老师：',
    ],

    'forbidden' => [
        'title' => '不能参加该场考试',
        'header' => '您不能参加该场考试。',
        'reason' => '由于我们未能在允许参加考试的学生名单中找到您的信息，所以您不能参加该场考试。',
        'solution' => '您可以检查您的资料中学号是否填写正确，或者联系您的老师解决这个问题。'
    ],

    'info' => [
        'trueFalse' => '判断题',
        'multiChoice' => '选择题',
        'blankFill' => '填空题',
        'shortAnswer' => '简答题',
        'general' => '综合题',
        'programBlankFill' => '程序填空题',
        'program' => '程序设计题',
    ]
];
