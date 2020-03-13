<?php
return [
    'alipay' => [
        'app_id' => '2016101700710398',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApGqgHTNdAUZL3JOYpFmasBGYE8jJpvtp70MYh9k3utcYQXzSAnVPzuQQ65g1wcZ6ENZliRMyuj+EBbw+ZxpVcHWSItikZl66MofpBiRt7Q3DFSx+TAWpgcQdKqmwvSu9lFzMVNhnV7vD3wFf4BBkUgvGD1mQSkjRU7uDxyJMAfJUeYvmmgxBOKPf/XYXisYaSCLBFJD2A5bjJFRghR+d2OjUUcWsf7VfRJ++/Zigc4rsCbr2eqhdSX3X6NMCv9bswl91nXvo0rT/OfugexYj3vCtooCSOJsgZEMFfnw94vu13Gqy9Uf+UhEbfLyqtnjhFoZIy0DZFqxh8jKsLZtxuwIDAQAB',
        'private_key' => 'MIIEpAIBAAKCAQEAgrd2NfXVSOrUmQuU2gKJiUex/T4FszEaWgXG7MUsdy1a30JntDIOXoXyxVDqSnIqByyWt9mv05cDsuh5rEHjPyez20i7LBIL/VLFZ9XKnz0Oj+OdFgIDmSDbR8fweUDZvFJjeAhY7YW2UBiNp8flzT1loRPtjH4/oVxVazWFLICAwC8UW+5UM8u2QlF30X5/6co+U6eZx/bdpsWxnUturX9my0G9mI5VjRLoaZfaQm9NGTehlizu2fmoMxem+OhIIOCDmKuBPb9t7Uxp8Ey1Hw9nXsnZsyvIB5Vf5U7yj1c7X9qr18AfBQePeaTutZMee3dE3tLCwrjDeTY25zY7UwIDAQABAoIBAH2Rl7EGUrkVPN04TumOfmitwsGvDvKwPMw1uH5CexCRNTY7KDvlyf/rVOdPb4HMYas6nh5Gs6zi6N64jAl50b8deJ0yJPuU6oeTN6cjrN2DXbXDxWca0DINahhubQdN0NwjmQH5otOpGxWeQJXoZUzfqf0uk4fez2lGtZejdibkc3aIOg1APwpjNx3nY1nFyaCZrq4RveII0RntJ0dQQFCUZaMY2ORN6TDfvquZbbmgJM3mvRJA7CYg0+RmAZWZSt+GODluF6DtgvZD+BhBDIJVcrfCZrSHEt9EYVshYWiI7hys/YsZX8usDh/kVVIw1cTaA0U+9CNPU8bhbo0n4EECgYEA4fQB4kbIqXeccPgBdKmJcR6A0glx5kzjQB571uAs4NKVjRdGzPqp4sKBIB38rxLgfrmGt7a8N+QSVADbAbiGFqDWT61IUl2/6oE/tAcZiW81mr37L1O/ukBejPYthXytVBmZgO0siC5F0j+5X4gEnC5tLUAfJOYgfZu5lHptk+sCgYEAlBlfgH3i8gPr/bwLubJ32YgdIqyMWMDxBcQFmajF+YMPwYCWhI+/FLOIsSLcb6JVrCSqglsx7+B2QqhAGhpsw486K5fSsaLNpPIhDIXc5XCBcRkmX9lv9b6pYM1imVsI7lO51MIth13GoLJz128+WoZ9TJELxOOn+QClx6l55DkCgYEAiJPzp5DdrgIM4AQo7RmlaGjluQ/Ydzq2ioVimcm7ltHzb+tH8pL5qYWkg4Ncv36LkE4YbmfYcXg80+YIe4vMEVV69YJqms7sOJWTqgA4oWhFYJnBgSQAWlaaUF5lubBZHOK0dMfoCRDfR20ZYfNXxggSGi4OJUGtFf/RNzyhi60CgYAJ3b7dAoXx9YztNG/biSYu2cCHJNOcvg3QgoSU/gdiXfbYv0ZHwoPKT0OV+WqSDVCDzVWGpaioAF4ghrDujEAerxYC/XRN3Tix+md1PB3BM0OMU06ZKBUrW+5Qwp4E9Wmc5vsET4NU90xaPEk3WvPeeAM07JzKGxh/oClrKcEzEQKBgQCBUTsxNkQYtJrJ6Qa39fFsMfoUMDpMbLulsSCw/bsX2MHMjUEgmlFkELH/sQdHea1yH7/EgYX/BTRHTkWBp9g6aLZblNrs268HPCQQHOdKyNOvKhM8pp5QvXfsGr8Ogp+qD1DsNKetvP5VcR+Tt9eMF8igC5inCjheSnMjNvaG3A==',
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ]
    ],
    'wechat' => [
        'app_id' => '',// 公众号 app id
        'mch_id' => '',// 第一步获取到的商户号
        'key' => '',// 刚刚设置的 API 密钥
        //resources/wechat_pay文件夹下
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key' => resource_path('wechat_pay/apiclient_key.pem'),
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];
