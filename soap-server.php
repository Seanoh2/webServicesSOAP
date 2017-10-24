<?php

/*
 * Written by: Peter Gosling, DkIT
 * Copyright 2016
 * 
 */

function getTeam($teamId) {
    mysql_connect('localhost', 'root', '');
    mysql_select_db('loi');

    $sql = "SELECT * FROM teams ORDER BY teamId";
    $res = mysql_query($sql);

    $xml = new XMLWriter();

    $xml->openURI("test.xml");
    $xml->startDocument();
    $xml->setIndent(true);

    $xml->startElement('Container');

    while ($row = mysql_fetch_assoc($res)) {
        $xml->startElement("Team");

        $xml->writeAttribute('teamId', $row['teamId']);
        $xml->writeRaw($row['teamName']);

        $xml->endElement();
    }

    $xml->endElement();

    header('Content-type: text/xml');
    $xml->flush();
}

function getResults() {
    mysql_connect('localhost', 'root', '');
    mysql_select_db('loi');

    $sql = "SELECT * FROM results ORDER BY ID";
    $res = mysql_query($sql);

    $xml = new XMLWriter();

    $xml->openURI("results.xml");
    $xml->startDocument();
    $xml->setIndent(true);

    $xml->startElement('Container');

    while ($row = mysql_fetch_assoc($res)) {
        $xml->startElement("Team");
        $xml->writeAttribute('id', $row['ID']);

        $xml->startElement("TeamName");
        $xml->writeAttribute('name', $row['Team']);

        $xml->startElement("Played");
        $xml->writeRaw($row['Played']);
        $xml->endElement();

        $xml->startElement("Won");
        $xml->writeRaw($row['Won']);
        $xml->endElement();

        $xml->startElement("Drew");
        $xml->writeRaw($row['Drew']);
        $xml->endElement();

        $xml->startElement("Lost");
        $xml->writeRaw($row['Lost']);
        $xml->endElement();

        $xml->startElement("GFor");
        $xml->writeRaw($row['GFor']);
        $xml->endElement();

        $xml->startElement("GAgainst");
        $xml->writeRaw($row['GAgainst']);
        $xml->endElement();

        $xml->startElement("Location");
        $xml->writeRaw($row['Location']);
        $xml->endElement();

        $xml->endElement();
        $xml->endElement();
        $xml->endElement();
    }

    $xml->endElement();

    header('Content-type: text/xml');
    $xml->flush();
}

ini_set("soap.wsdl_cache_enabled", "0");
$server = new SoapServer("LOI.wsdl");
$server->addFunction("getTeam");
$server->addFunction("getResults");
$server->handle();
?>