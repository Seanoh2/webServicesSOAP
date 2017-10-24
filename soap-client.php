<?php
  $client = new SoapClient("LOI.wsdl");
  $teamId='team1';
  $response = $client->getTeam($teamId);
  $response2 = $client->getResults();
  echo $response;
?>