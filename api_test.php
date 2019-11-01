<?php

function uploadRepoFile($filePath, $fileContent, $message = 'Added file')
{
    $request = new HttpRequest();
    $request->setUrl('https://api.github.com/repos/PonomareVlad/OGLinks/contents/' . $filePath);
    $request->setMethod(HTTP_METH_PUT);

    $request->setHeaders(array(
        'cache-control' => 'no-cache',
        'Connection' => 'keep-alive',
        'Content-Length' => '152',
        'Accept-Encoding' => 'gzip, deflate',
        'Host' => 'api.github.com',
        'Postman-Token' => '98ee36f1-d4e6-4290-bd44-0643b2c196cd,602cc6b6-c8fa-4295-aec5-fce0d76f2f8b',
        'Cache-Control' => 'no-cache',
        'Accept' => '*/*',
        'User-Agent' => 'PostmanRuntime/7.18.0',
        'Authorization' => 'Bearer 381e4be5a6091e662250831424993f8d31585006',
        'Content-Type' => 'application/json'
    ));

    $request->setBody();

    try {
        $response = $request->send();

        return $response->getBody();
    } catch (HttpException $ex) {
        return $ex;
    }
}

function uploadRepoFile2($filePath, $fileContent, $message = 'Added file')
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
                "Authorization: Bearer 381e4be5a6091e662250831424993f8d31585006\r\n",
            'content' => $postdata
        )
    );

    $context = stream_context_create($opts);

    return $result = file_get_contents('https://github.requestcatcher.com/repos/PonomareVlad/OGLinks/contents/' . $filePath, false, $context);
}

function createPage($targetUrl, $imgUrl, $title)
{
    ob_start();
    require 'page.php';
    return ob_get_clean();
}

if (!isset($_REQUEST['url'], $_REQUEST['image'], $_REQUEST['title'], $_REQUEST['path'])) exit('Error in parameters');

exit(uploadRepoFile2($_REQUEST['path'], createPage($_REQUEST['url'], $_REQUEST['image'], $_REQUEST['title']), $_REQUEST['url']));