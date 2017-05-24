<?php

require_once 'Menu_Widget.php';

//Top Navigation
class Side_Nav extends Menu_Widget {
	
	//Display Side Menu
	public function display($p_template, $p1 = null, $p2 = null, $p3 = null) {	//Signature Must Match Menu_Widget.display (Need Better Work Around)
		
		//Display Menu
		parent::display(	$p_template, 
							'nav_main', 
							'nav_main', 
							//Custom Formatting
							function($p_dom){
								//Create XPATH
								$xpath = new DOMXpath($p_dom);
									
								//Set Class For Outer UL
								$xpath->query('/ul')->item(0)->setAttribute('class', 'nav side-menu');
								
								/*********************************************************************/
								//Get Nested Lists
								$l_nestedLists = $xpath->query('/ul/li/ul');
								
								//Give Class Child_menu
								if(!is_null($l_nestedLists)){
									foreach($l_nestedLists as $i_innerList){
										$i_innerList->setAttribute('class', 'nav child_menu');
									}
								}
								/*********************************************************************/
								
								//Find Category Headers
								$l_categoryHeaders = $xpath->query('/ul/li/a');
								
								//Add Formatting 
								if(!is_null($l_categoryHeaders)){
									foreach($l_categoryHeaders as $i_header){
										
										//Add Drop Down Chevron
										$l_span = $p_dom->createElement('span');
										$l_span->setAttribute('class', 'fa fa-chevron-down');
										$i_header->appendChild($l_span);
										
									}
								}
								
								return $p_dom;
							}
		);
	}
	

				   
}

