<?php

  define("ABS_PATH","/taxonomy/");
  define("ROOT","../../");
//  define("BASE_URI","http://localhost/taxonomy/");
  define("BASE_URI","https://ipsoeu.github.io/taxonomy/");
  define("TOOL_ACRONYM","IPS Taxonomies");
  define("TOOL_NAME","Innovative Public Services Taxonomies");
  define("ABOUT_URL","https://github.com/ipsoeu/taxonomy");
  define("ABOUT_TEXT","IPS Taxonomy is an experimental Linked Data implementation of the taxonomies developed in the framework of the Innovative Public Services (IPS) Action of the EU ISA² Programme, and used in the service catalogue of the IPS Observatory (IPSO).");
  define("PUBLISHER_NAME","European Commission");
  define("PUBLISHER_URL","http://publications.europa.eu/resource/authority/corporate-body/COM");
  define("LICENCE_NAME","CC-BY 4.0");
  define("LICENCE_URL","http://creativecommons.org/licenses/by/4.0/");
  define("SKOS_TO_HTML","../xslt/skos2html.xsl");

//  $abs_path = parse_url(BASE_URI, PHP_URL_PATH);

  $formats["html"]["code"] = "format_html";
  $formats["html"]["label"] = "HTML";
  $formats["html"]["mdr"] = "HTML";
  $formats["html"]["iana"] = "text/html";

  $formats["rdf"]["code"] = "format_rdf";
  $formats["rdf"]["label"] = "RDF/XML";
  $formats["rdf"]["mdr"] = "RDF_XML";
  $formats["rdf"]["iana"] = "application/rdf+xml";
  
//  formats["ttl"]["code"] = "format_ttl";
//  formats["ttl"]["label"] = "Turtle";
//  formats["ttl"]["mdr"] = "RDF_TURTLE";
//  formats["ttl"]["iana"] = "text/turtle";

//  formats["jsonld"]["code"] = "format_jsonld";
//  formats["jsonld"]["label"] = "JSON-LD";
//  formats["jsonld"]["mdr"] = "JSON_LD";
//  formats["jsonld"]["iana"] = "application/ld+json";

//  formats["nt"]["code"] = "format_nt";
//  formats["nt"]["label"] = "N-Triples";
//  formats["nt"]["mdr"] = "RDF_N_TRIPLES";
//  formats["nt"]["iana"] = "application/n-triples";

//  formats["n3"]["code"] = "format_n3";
//  formats["n3"]["label"] = "N3";
//  formats["n3"]["mdr"] = "N3";
//  formats["n3"]["iana"] = "text/n3";

//  formats[""]["code"] = "";
//  formats[""]["label"] = "";
//  formats[""]["mdr"] = "";
//  formats[""]["iana"] = "";

  foreach ($formats as $k => $v) {
    $formats[$k]["title"] = $formats[$k]["label"] . " representation";
    $formats[$k]["description"] = $formats[$k]["label"] . " representation";
  }

  $claset  = "technology";
  $version = "2019";
//  $claset  = "type";
//  $version = "2019";

  $dataset["geo-extent"]["id"] = "geo-extent";
//  $dataset["geo-extent"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["geo-extent"]["name"] = "Geo extent";
  $dataset["geo-extent"]["description"] = "The different levels in which public administraitions can be classified.";
  $dataset["geo-extent"]["versions"] = array("2019");
  
  $dataset["organisation-category"]["id"] = "organisation-category";
//  $dataset["organisation-category"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["organisation-category"]["name"] = "Organisation categories";
  $dataset["organisation-category"]["description"] = "The categories in which organisations can be classified.";
  $dataset["organisation-category"]["versions"] = array("2019");
  
  $dataset["status"]["id"] = "status";
//  $dataset["theme"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["status"]["name"] = "Service statuses";
  $dataset["status"]["description"] = "The maturity statuses of a service.";
  $dataset["status"]["versions"] = array("2019");
  
  $dataset["technology"]["id"] = "technology";
//  $dataset["pattern"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["technology"]["name"] = "Technologies";
  $dataset["technology"]["description"] = "The set of technologies in scope with the Innovative Public Services (IPS) Action of the EU ISA2 Programme.";
  $dataset["technology"]["versions"] = array("2019");
  
  $dataset["type"]["id"] = "type";
//  $dataset["type"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["type"]["name"] = "Service types";
  $dataset["type"]["description"] = "The type of a public service with respect to the aims it was set up, and the application of the relevant technology.";
  $dataset["type"]["versions"] = array("2019");
  
  $dataset["uptake"]["id"] = "uptake";
//  $dataset["uptake"]["isdefinedby"] = "https://joinup.ec.europa.eu/sites/default/files/news/2019-09/ISA2_European%20taxonomy%20for%20public%20services.pdf";
  $dataset["uptake"]["name"] = "Uptake";
  $dataset["uptake"]["description"] = "The levels of uptake by stakeholders of a given service or initiative.";
  $dataset["uptake"]["versions"] = array("2019");
  
  $xsluri["rdf2html"] = SKOS_TO_HTML;

  $src_uri["geo-extent"]["2019"]["csv"] = '../src/geo-extent-2019.csv';
  $src_uri["organisation-category"]["2019"]["csv"] = '../src/organisation-category-2019.csv';
  $src_uri["status"]["2019"]["csv"] = '../src/status-2019.csv';
  $src_uri["technology"]["2019"]["csv"] = '../src/technology-2019.csv';
  $src_uri["type"]["2019"]["csv"] = '../src/type-2019.csv';
  $src_uri["uptake"]["2019"]["csv"] = '../src/uptake-2019.csv';

?>
