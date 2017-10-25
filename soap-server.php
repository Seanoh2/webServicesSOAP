<?php

/*
 * Written by: Peter Gosling, DkIT
 * Copyright 2016
 * 
 */

function getTeam() {
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

    $sql = "SELECT * FROM matches ORDER BY ID";
    $res = mysql_query($sql);

    $xml = new XMLWriter();

    $xml->openURI("results.xml");
    $xml->startDocument();
    $xml->setIndent(true);

    $xml->startElement('Container');

    while ($row = mysql_fetch_assoc($res)) {
        $xml->startElement("Team");
        $xml->writeAttribute('id', $row['ID']);

        $xml->startElement("gameDate");
        $xml->writeRaw($row['gameDate']);
        $xml->endElement();
        
        $xml->startElement("homeTeam");
        $xml->writeRaw($row['homeTeam']);
        $xml->endElement();
        
        $xml->startElement("homeGoal");
        $xml->writeRaw($row['homeGoal']);
        $xml->endElement();
        
        $xml->startElement("awayGoal");
        $xml->writeRaw($row['awayGoal']);
        $xml->endElement();
        
        $xml->startElement("awayTeam");
        $xml->writeRaw($row['awayTeam']);
        $xml->endElement();

        $xml->startElement("attendance");
        $xml->writeRaw($row['attendance']);
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