<?php

return array(


    'pdf' => array(
        'enabled' => true,
        // 'binary'  => '/usr/local/bin/wkhtmltopdf',
        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        // 'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => array(
            'enable-local-file-access' => true,
            // 'orientation'   => 'landscape',
            'encoding'      => 'UTF-8'
        ),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
