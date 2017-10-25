<?php
  $client = new SoapClient("LOI.wsdl");
  $response = $client->getTeam();
  $response2 = $client->getResults();
  echo $response;
?>