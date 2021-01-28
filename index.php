<?php

require_once "./vendor/autoload.php";

use \GuzzleHttp\Client;
use \Symfony\Component\DomCrawler\Crawler;

$response = new Client();
$html = $response->get("http://www.guiatrabalhista.com.br/guia/salario_minimo.htm")->getBody()->getContents();
$crawler = new Crawler($html);

$array = $crawler->filter("#content table")->filter("tr")->nextAll()->each(function($tr, $i){
    return array_map("trim", [
        "vigencia" => $tr->children()->eq(0)->text(),
        "valor_mensal" => $tr->children()->eq(1)->text(),
        "valor_diario" => $tr->children()->eq(2)->text(),
        "valor_hora" => $tr->children()->eq(3)->text(),
        "norma_legal" => $tr->children()->eq(4)->text()
    ]);
});

echo "<pre>";
print_r($array);
echo "</pre>";