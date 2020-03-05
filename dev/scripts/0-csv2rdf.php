<?php

  ini_set('display_errors',1);
  error_reporting(-1);
  set_time_limit(600);

  include("config.php");

  $base_uri = BASE_URI;

/*
  $xml = new DOMDocument;
  $xml = new DOMDocument;
  $xml->load($xmluri[$claset][$version]["xml"]);

  $xsl = new DOMDocument;
  $xsl->load($xsluri[$claset]["xml2rdf"]);

  $proc = new XSLTProcessor();
  $proc->importStyleSheet($xsl);
  $proc->setParameter('', 'classification-uri', $base_uri . $claset . '/');
  foreach ($formats as $k => $n) {
    $proc->setParameter('', $formats[$k]["code"], "yes");
  }
 
  $output = $proc->transformToXML($xml);
*/

  $csv = array_map('str_getcsv', file("../src/concept-scheme.csv"));
  array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
  });
  array_shift($csv);

  $cs = array();
  foreach ($csv as $k => $v) {
    $cs[$v["id"]][$v["version"]]["id"] = $v["id"];
    $cs[$v["id"]][$v["version"]]["version"] = $v["version"];
    $cs[$v["id"]][$v["version"]]["name"] = $v["name"];
    $cs[$v["id"]][$v["version"]]["description"] = $v["description"];
    $cs[$v["id"]][$v["version"]]["definedby"] = $v["definedby"];
    $cs[$v["id"]][$v["version"]]["publisher"] = $v["publisher"];
    $cs[$v["id"]][$v["version"]]["issued"] = $v["issued"];
    $cs[$v["id"]][$v["version"]]["validfrom"] = $v["validfrom"];
    $cs[$v["id"]][$v["version"]]["validuntil"] = $v["validuntil"];
  }

//  print_r($cs);
//  exit;

  $ns["dcat"] = 'http://www.w3.org/ns/dcat#';
  $ns["dct"]  = 'http://purl.org/dc/terms/';
  $ns["gsp"]  = 'http://www.opengis.net/ont/geosparql#';
  $ns["owl"]  = 'http://www.w3.org/2002/07/owl#';
  $ns["rdf"]  = 'http://www.w3.org/1999/02/22-rdf-syntax-ns#';
  $ns["rdfs"] = 'http://www.w3.org/2000/01/rdf-schema#';
  $ns["skos"] = 'http://www.w3.org/2004/02/skos/core#';
  $ns["xkos"] = 'http://rdf-vocabulary.ddialliance.org/xkos#';
  $ns["xsd"]  = 'http://www.w3.org/2001/XMLSchema#';
  $ns["wdrs"] = 'http://www.w3.org/2007/05/powder-s#';
  $ns["ft"]   = 'http://publications.europa.eu/resource/authority/file-type/';
  $ns["mt"]   = 'https://www.iana.org/assignments/media-types/';

  $namespaces = array();
  foreach ($ns as $k => $v) {
    $namespaces[] = 'xmlns:' . $k . '="' . $v . '"';
  }

  $header  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
  $header .= '<rdf:RDF ' . join(" ", $namespaces) . '>' . "\n";

  foreach ($dataset as $dk => $dv) {
    $claset = $dk;
    foreach ($dataset[$dk]["versions"] as $dvv) {
      $version = $dvv;

//  echo $claset . "\n";
//  echo $version. "\n";

//  $src = "../../" . $claset . "/" . $version . ".rdf";
  $target_folder = "../../" . $claset;

  if (!file_exists($target_folder)) {
    mkdir($target_folder);
  }

  $csv = array_map('str_getcsv', file($src_uri[$claset][$version]["csv"]));
  array_walk($csv, function(&$a) use ($csv) {
    $a = array_combine($csv[0], $a);
  });
  array_shift($csv);

  $output  = $header;
  $output .= '  <rdf:Description rdf:about="' . $base_uri . $claset . '/' . $version . '">' . "\n";
  $output .= '    <rdf:type rdf:resource="' . $ns['dcat'] . 'Dataset"/>' . "\n";
  $output .= '    <rdf:type rdf:resource="' . $ns['skos'] . 'ConceptScheme"/>' . "\n";
  $output .= '    <dct:identifier>' . $claset . '-' . $version . '</dct:identifier>' . "\n";
  $output .= '    <owl:versionInfo>' . htmlspecialchars($version) . '</owl:versionInfo>' . "\n";
  $output .= '    <dct:isVersionOf rdf:resource="' . $base_uri . $claset . '"/>' . "\n";
//  $output .= '    <dct:alternative>' . htmlspecialchars($cs[$claset][$version]['id']) . '-' . $version . '</dct:alternative>' . "\n";
  $output .= '    <dct:title xml:lang="en">' . htmlspecialchars($cs[$claset][$version]['name']) . '</dct:title>' . "\n";
  if (trim($cs[$claset][$version]['description']) != '') {
    $output .= '    <dct:description xml:lang="en">' . htmlspecialchars($cs[$claset][$version]['description']) . '</dct:description>' . "\n";
  }
  $output .= '    <dct:issued rdf:datatype="' . $ns['xsd'] . 'date">' . htmlspecialchars($cs[$claset][$version]['issued']) . '</dct:issued>' . "\n";
  $output .= '    <dct:valid rdf:datatype="' . $ns['xsd'] . 'date">' . htmlspecialchars($cs[$claset][$version]['validfrom']) . '</dct:valid>' . "\n";
  $output .= '    <wdrs:validfrom rdf:datatype="' . $ns['xsd'] . 'date">' . htmlspecialchars($cs[$claset][$version]['validfrom']) . '</wdrs:validfrom>' . "\n";
  if (trim($cs[$claset][$version]['validuntil']) != '') {
    $output .= '    <wdrs:validuntil rdf:datatype="' . $ns['xsd'] . 'date">' . htmlspecialchars($cs[$claset][$version]['validuntil']) . '</wdrs:validuntil>' . "\n";
  }
  $output .= '    <dcat:landingPage rdf:resource="' . $base_uri . $claset . '/' . $version . '"/>' . "\n";
  $output .= '    <rdfs:isDefinedBy rdf:resource="' . $cs[$claset][$version]['definedby'] . '"/>' . "\n";
  if (trim($cs[$claset][$version]['publisher']) != '') {
    $output .= '    <dct:publisher rdf:resource="' . $cs[$claset][$version]['publisher'] . '"/>' . "\n";
  }
  $output .= '    <dct:license rdf:resource="' . LICENCE_URL . '"/>' . "\n";
  foreach ($csv as $k => $v) {
    if (trim($v["parent"]) == '') {
      $output .= '    <skos:hasTopConcept rdf:resource="' . $base_uri . $claset . '/' . $version . '/' . $v['id'] . '"/>' . "\n";
    }
  }
  $output .= '  </rdf:Description>' . "\n";
  foreach ($csv as $k => $v) {
    $output .= '  <rdf:Description rdf:about="' . $base_uri . $claset . '/' . $version . '/' . $v['id'] . '">' . "\n";
    $output .= '    <rdf:type rdf:resource="' . $ns['skos'] . 'Concept"/>' . "\n";
    $output .= '    <dct:identifier>' . htmlspecialchars($v['id']) . '</dct:identifier>' . "\n";
    $output .= '    <skos:notation>' . htmlspecialchars($v['id']) . '</skos:notation>' . "\n";
    $output .= '    <skos:prefLabel xml:lang="en">' . htmlspecialchars($v['name']) . '</skos:prefLabel>' . "\n";
    if (trim($v["description"]) != '') {
      $output .= '    <skos:definition xml:lang="en">' . htmlspecialchars($v['description']) . '</skos:definition>' . "\n";
    }
    $output .= '    <skos:inScheme rdf:resource="' . $base_uri . $claset . '/' . $version . '"/>' . "\n";
    if (trim($v["parent"]) == '') {
      $output .= '    <skos:topConceptOf rdf:resource="' . $base_uri . $claset . '/' . $version . '"/>' . "\n";
    }
    if (trim($v["parent"]) != '') {
      $output .= '    <skos:broader rdf:resource="' . $base_uri . $claset . '/' . $version . '/' . $v['parent'] . '"/>' . "\n";
    }
    foreach ($csv as $kk => $vv) {
      if (trim($vv["parent"]) == $v["id"]) {
        $output .= '    <skos:narrower rdf:resource="' . $base_uri . $claset . '/' . $version . '/' . $vv['id'] . '"/>' . "\n";
      }
    }
    $output .= '  </rdf:Description>' . "\n";
  }
  $output .= '</rdf:RDF>' . "\n";

//  print_r($csv);
//  exit;
//  echo $output;
//  exit;

  file_put_contents($target_folder . '/' . $version . '.rdf', $output);
  echo $target_folder . '/' . $version . '.rdf' . "\n";
//  header('Content-type: application/xml; charset=utf8');
//  echo $output;

    }
  }

?>
