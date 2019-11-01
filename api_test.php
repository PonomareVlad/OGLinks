<?php

function uploadRepoFile($filePath, $fileContent, $message = 'Added file')
{
    $postdata = '{
  "message": "' . $message . '",
  "committer": {
    "name": "PonomareVlad",
    "email": "git@ponomarevlad.ru"
  },
  "content": "' . base64_encode($fileContent) . '"
}';

    $opts = array('http' =>
        array(
            'method' => 'PUT',
            'header' => "Content-Type: application/json\r\n" .
                "Cache-Control: no-cache\r\n" .
                "Accept-Encoding: gzip, deflate\r\n" .
                "Postman-Token: 98ee36f1-d4e6-4290-bd44-0643b2c196cd,602cc6b6-c8fa-4295-aec5-fce0d76f2f8b\r\n" .
                "Accept: */*\r\n" .
                "User-Agent: PostmanRuntime/7.18.0\r\n" .
                "Authorization: Bearer 66866baac569bc9fd3c8ed0341a23a2c7864126d\r\n",
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);

    return $result = file_get_contents('https://api.github.com/repos/PonomareVlad/OGLinks/contents/' . $filePath, false, $context);
}

function createPage($targetUrl, $imgUrl, $title)
{
    ob_start();
    require 'page.php';
    return ob_get_clean();
}

$data = $_REQUEST;

if (!isset($_REQUEST['url'], $_REQUEST['image'], $_REQUEST['title'], $_REQUEST['path'])) exit('Error in parameters');

/*$data = json_decode('{
"url":"https://www.instagram.com/ponomarevlad/"
"image":https://avatars1.githubusercontent.com/u/2877584"
"title":Владислав Пономарев"
"path":instagram.html"
}');*/

//echo print_r($data, true);

echo(uploadRepoFile($data['path'], createPage($data['url'], $data['image'], $data['title']), $data['url']));