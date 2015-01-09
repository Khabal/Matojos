<?php
/******************************************************************************
 * Archivo: uielement.php
 * Contenido: Clase UiElement con funciones para escritura de código HTML para
 * mostrar la página web del SIG de flora que actúa como interfaz gráfica.
 * Autor: Óscar El Becario Eterno.
 * Versión: 0.0.10 (Preludio Alfalfa) - 22/12/2014
 * Descripción: Archivo de texto plano precioso y encantador de código PHP
 * para generar los elementos de la página web que muestre el mapa de flora,
 * como cabecera, pie, menú, leyenda, además de ir actualizando dichos
 * elementos en base a las capas seleccionadas, opciones y demás interacciones.
 * 
 * Notas: Nada a desastacar... por ahora. Todas las cañerías en orden.
 *
 ******************************************************************************/


/**
 * UI elements to be inserted into main doc
 */
class UiElement{

   /**
    * Map zone
    */
    public static function mapZone(){
        $html = "<div id=\"map\" class=\"baselayout\">
                <!-- MAIN MAP -->
                <div id=\"mapimgLayer\">
                        <img id=\"mapImg\" src=\"images/pixel.gif\"  style=\"overflow:hidden;\" alt=\"\" />
                </div>
                <div id=\"measureLayer\" class=\"measureLayer\"></div>
                <div id=\"measureLayerTmp\" class=\"measureLayer\"></div>
                <div id=\"zoombox\" class=\"zoombox\"></div>
                <div id=\"helpMessage\"></div>
                <div id=\"scalebar\"></div>
                <div id=\"iqueryContainer\"></div>
                <div id=\"loading\"><img id=\"loadingimg\" src=\"images/cargando.gif\" alt=\"Cargando\" /></div>
            </div>
        ";
        return $html;
    }


   /**
    * Toolbar
    */
    public static function toolBar($buttons, $toolbarTheme="tuneado", $toolBarOrientation="v", $toolbarImgType="png", $cellspacing="4"){
        $html  = "<div id=\"toolBar\" class=\"pm-toolframe\">";
        $html .= "<table class=\"pm-toolbar\" border=\"0\" cellspacing=\"$cellspacing\" cellpadding=\"0\">\n";
        $html .= ($toolBarOrientation == "v" ? "" : "<tr>");
		//XXX
//$toolbarTheme="tuneado";
//$toolbarImgType="png";
//XXX
        foreach ($buttons as $b => $ba) {
            $html .= ($toolBarOrientation == "v" ? "<tr>" : "");

            if (preg_match("/^space/i", $b)) {
                $html .= "<td class=\"pm-tsepspace\" style=" . ($toolBarOrientation == "v" ? "height:" : "width:") . $ba . "px\"> </td> ";
                
            } elseif (preg_match("/^separator/i", $b)) {
                $iewa = ($_SESSION['userAgent'] == "ie" ? "<img alt=\"separator\" src=\"images/blank.gif\" />" : "");
                if ($toolBarOrientation == "v") {
                    $html .= "<td class=\"pm-tsepv\">$iewa</td> ";
                } else {
                    $html .= "<td class=\"pm-tseph\">$iewa</td> ";
                } 

            } else {
			//($ba[1] == "0" ?  "onmousedown=\"setTbTDButton('$b');domouseclick('$b')\"" : "onmousedown=\"TbDownUp('$b','d')\" onmouseup=\"TbDownUp('$b','u')\"") .
                $html .= "<td class=\"pm-toolbar-td\" id=\"tb_$b\"  " .                         
                        ($ba[1] == "0" ?  "onmousedown=\"setTbTDButton('$b');\"" : "onmousedown=\"TbDownUp('$b','d')\" onmouseup=\"TbDownUp('$b','u')\"") .
                        " onclick=\"" . ($ba[1] == "0" ? "domouseclick('$b')" : "$ba[1]()") .  "\">" .
                        "<img id=\"img_$b\"  src=\"images/buttons/$toolbarTheme/$b"."_off.$toolbarImgType\" title=\"$ba[0]\" alt=\"$ba[0]\" height=\"24px\" width=\"24px\" /></td>" ;
            }

            $html .= ($toolBarOrientation == "v" ? "</tr> \n" : "\n");
        }
        $html .= ($toolBarOrientation == "v" ? "" : "</tr> \n");
        $html .= "</table>";
        $html .= "</div>";
        
        return $html;
    }
    
   /**
    * TOC and Legend container
    */
    public static function toolMenu($menu, $menuid, $menuname)
    {    
        $html  = "<div id=\"tool$menuid\">";
        $html .= "<a id=\"pm_". $menuid ."_start\" class=\"pm-menu-button\"   onclick=\"pmMenu_toggle('pm_$menuid');\">" . _p($menuname) . "<img src=\"images/menudown.gif\" alt=\"\" /></a>\n";
        $html .= "<ul id=\"pm_" . $menuid . "\" class=\"pm-menu\" >";
        foreach ($menu as $m => $ma) {
            $html .= "<li id=\"pmenu_" . $ma[1] . "\">" . $ma[0] . "</li>\n";      
        }
        $html .= "</ul>";
        $html .= "</div>";
        
        return $html;  
    }
    
    
    /**
    * Tool links
    */
    public static function toolLinks($menu)
    {    
        $html  = "<div id=\"toolLinkContainer\"><ul class=\"pm-tool-links\">";
        foreach ($menu as $m => $ma) {
            $html .= "<li>";
            $html .= "<a id=\"plink_$m\" href=\"javascript:{$ma[1]}()\">\n";
            $html .= "<img style=\"background:transparent url(images/menus/{$ma[2]}) no-repeat;height:16px;width:16px\" src=\"images/transparent.png\" alt=\"$m\" />";
            $html .= "<span>{$ma[0]}</span></a></li>\n";
        }
        $html .= "</ul></div>";
        
        return $html;  
    }

	/**
	 * Panel lateral - Leyenda / Selector de capas
	 */
	public static function PL_Leyenda($userAgent) {
		
		// Código HTML
		$html = "<div id=\"leyenda\">
					<p class=\"leyenda-cabecera\">Leyenda / Selector de capas</p>
					<form id=\"layerform\" method=\"get\" action=\"\">
						<div id=\"toc\" class=\"TOC\" style=\"" . ($userAgent == "mozilla" ? "height:100%" : "height:auto") . ";\"></div>
						<div id=\"toclegend\" class=\"TOC\" style=\"" . ($userAgent == "mozilla" ? "height:100%" : "height:auto") . "; display:none;\"></div>
					</form>
				</div>";
		
		// Devolver código HTML
		return $html;
    }
    
   /**
    * TOC and Legend container
    */
    public static function tocContainer($userAgent)
    {
        //$html = "<div id=\"tocContainer\">
		$html = "<div id=\"leyenda\">
			<div>Mapas</div>
              <form id=\"layerform\" method=\"get\" action=\"\">    
                <div id=\"toc\"       class=\"TOC\" style=\"" . ($userAgent == "mozilla" ? "height:100%" : "height:auto") ."; \"></div>
                <div id=\"toclegend\" class=\"TOC\" style=\"" . ($userAgent == "mozilla" ? "height:100%" : "height:auto") . "; display:none;\"></div>
              </form>
            </div>
        ";
        return $html;
    }
    
    
    /**
     * Create tabs for TOC/Legend
     */
    public static function tocTabs($tablist, $enable=false)
    {
        $html = "";
        if ($_SESSION['layerAutoRefresh'] == 0) {
            $html .= "<div id=\"autoRefreshButton\"></div>";
        }
        if ($_SESSION['legendStyle'] == "swap" || $enable) { 
            $html .= "  <div id=\"tocTabs\">\n       <ul class=\"tocTabs\">\n";
            foreach($tablist as $k => $v) {
                $html .= "         <li><a href=\"javascript:" . $v[1] . "()\"  id=\"tab_$k\">" . $v[0] . "</a></li>\n";                
            }
            $html .= "       </ul> \n     </div>\n";
        } else {
            $html .= "";
        }
        return $html;
    }
    
    
   /**
    * Reference map
    */
    public static function refMap($refH, $refW, $refImg, $refH, $refW)
    {
        $html ="<div id=\"refmap\" class=\"refmap\" style=\"width:{$refW}px; height:{$refH}px\" >
                <img id=\"refMapImg\" src=\"images/$refImg\" width=\"$refW\"  height=\"$refH\"  alt=\"\" />
                <div id=\"refsliderbox\" class=\"sliderbox\"></div>
                <div id=\"refbox\" class=\"refbox\"></div>
                <div id=\"refcross\" class=\"refcross\"><img id=\"refcrossimg\" src=\"images/refcross.gif\"  alt=\"\" /> </div>
                <div id=\"refboxCorner\"></div>
            </div>
        ";
        return $html;
    }
    
   /**
    * Search form 
    */
    public static function searchContainer($style)
    {
        $html  = "<div id=\"searchContainer\">";
        $html .= "<form id=\"searchForm\" action=\"blank.html\" onsubmit=\"PM.Query.submitSearch()\" onkeypress=\"return PM.Query.disableEnterKey(event)\">";
        $html .= "<table width=\"100%\" class=\"pm-searchcont pm-toolframe\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
        $html .= "<tr>";  
        $html .= "<td id=\"searchoptions\" class=\"pm-searchoptions\" style=\"padding:0px 8px\"></td>";  
        if ($style == "block") $html .= "</tr><tr>";    
        $html .= "<td id=\"searchitems\" class=\"pm_search_$style\"></td>";
        $html .= "</tr>";  
        $html .= "</table>";
        $html .= "</form>";
        $html .= "</div>";
        
		//Núcleos, prques, jardines, árboles...
		// Desplegable
		// <div id="flechitaTipoDeBusqueda"></div>
// <div id="inputTipoDeBusqueda" name="inputTipoDeBusqueda" style="-moz-user-select: none;">Dirección</div>
// <div id="tipoDeBusquedaListado">
// <ul id="ulTipoDeBusquedaListado">
// <li>
// <div id="TipoDeBusqueda1" value="1">Dirección</div>
// </li>
// <li>
// <div id="TipoDeBusqueda2" value="2">Dirección exacta</div>
// </li>
// <li>
// <div id="TipoDeBusqueda3" value="3">Polígono y Parcela</div>
// </li>
// <li>
// <li>
// <li>
// <li>
// </ul>
// </div>
// </div>

        $html  = "<div id=\"searchContainer\">";
        $html .= "<form id=\"searchForm\" action=\"blank.html\" onsubmit=\"PM.Query.submitSearch()\" onkeypress=\"return PM.Query.disableEnterKey(event)\">";
        //$html .= "<table width=\"100%\" class=\"pm-searchcont pm-toolframe\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$html .= "<div id=\"dropdownTipoDeBusqueda\">";
        $html .= " <div id=\"flechitaTipoDeBusqueda\"></div>";
        $html .= " <div id=\"inputTipoDeBusqueda\" name=\"inputTipoDeBusqueda\" style=\"-moz-user-select: none;\">Dirección</div><div id=\"tipoDeBusquedaListado\"><ul id=\"ulTipoDeBusquedaListado\"><li><div id=\"TipoDeBusqueda1\" value=\"1\">Dirección</div></li><li><div id=\"TipoDeBusqueda2\" value=\"2\">Dirección exacta</div></li></ul></div></div>";
        //$html .= "<tr>";  
        //$html .= "<td id=\"searchoptions\" class=\"pm-searchoptions\" style=\"padding:0px 8px\"></td>";  
        //if ($style == "block") $html .= "</tr><tr>";    
        //$html .= "<td id=\"searchitems\" class=\"pm_search_$style\"></td>";
        //$html .= "</tr>";  
        //$html .= "</table>";
		$html .= "<div id=\"divBuscarDireccion\">";
            $html .= "<input type=\"submit\" name=\"BuscarDireccion\" value=\"\" class=\"buttonBuscar\" id=\"BuscarDireccion\">";
            $html .= "</div>";
        $html .= "</form>";
        $html .= "</div>";

// <div id="divTopSearch" style="display: block; z-index: 0; position: absolute; left: 88px; top: 0px;">
        // <form class="form" action="javascript:void(0);" onsubmit="SubmitBuscar(); return false;" id="formDireccion">
            // <div id="dropdownTipoDeBusqueda">
                // <div id="flechitaTipoDeBusqueda"></div>
            // <div id="inputTipoDeBusqueda" name="inputTipoDeBusqueda" style="-moz-user-select: none;">Dirección</div><div id="tipoDeBusquedaListado"><ul id="ulTipoDeBusquedaListado"><li><div id="TipoDeBusqueda1" value="1">Dirección</div></li><li><div id="TipoDeBusqueda2" value="2">Dirección exacta</div></li><li><div id="TipoDeBusqueda3" value="3">Polígono y Parcela</div></li><li><div id="TipoDeBusqueda4" value="4">Referencia Catastral</div></li><li><div id="TipoDeBusqueda5" value="5">Coords. Geográficas</div></li><li><div id="TipoDeBusqueda6" value="6">Coordenadas UTM</div></li><li><div id="TipoDeBusqueda7" value="7">Ruta</div></li></ul></div></div>
                    
            // <div id="divTextboxBuscador"><input type="text" id="TextDireccion" name="TextDireccion" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Introduce la dirección" value="Introduce la dirección" tabindex="1" autocomplete="off"><input type="text" id="TextReferencia" name="TextReferencia" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Referencia catastral de la parcela" value="Referencia catastral de la parcela"><div id="divDireccionExacta"><select id="provincias2" name="provincias2" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" style="width: 80px;"></select><select id="poblaciones2" name="poblaciones2" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" style="width: 96px;"></select><select id="calles" name="calles" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" style="width: 96px;"></select><input type="text" id="numero" name="numero" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" placeholder="nº" style="width: 25px;" value="nº"></div><div id="divPoligonoYParcela"><select id="provincias" name="provincias" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" style="width: 90px;"></select><select id="poblaciones" name="poblaciones" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" style="width: 140px;"></select><input type="text" id="poligono" name="poligono" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" placeholder="Pol." style="width: 30px;" value="Pol."><div class="separador"></div><input type="text" id="parcela" name="parcela" class="textBoxRoudedLeft" classname="textBoxRoudedLeft" placeholder="Parc." style="width: 30px;" value="Parc."></div><div id="divCoordenadasGeograficas"><input type="text" id="latitud" name="latitud" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Latitud" style="width: 146px;" value="Latitud"><div class="separador"></div><input type="text" id="longitud" name="longitud" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Longitud" style="width: 144px;" value="Longitud"></div><div id="DivCoordenadasUTM"><input type="text" id="CoordenadaX" name="CoordenadaX" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Norte" style="width: 94px;" value="Norte"><div class="separador"></div><input type="text" id="CoordenadaY" name="CoordenadaY" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Este" style="width: 94px;" value="Este"><div class="separador"></div><input type="text" id="Zona" name="Zona" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Zona" style="width: 90px;" value="Zona"></div><div id="DivBusquedaRuta"><input type="text" id="DivBusquedaRutaDesde" name="DivBusquedaRutaDesde" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Desde" style="width: 144px;" value="Desde"><div class="separador"></div><input type="text" id="DivBusquedaRutaHasta" name="DivBusquedaRutaHasta" class="textBoxBuscador" classname="textBoxBuscador" placeholder="Hasta" style="width: 144px;" value="Hasta"></div></div>
            // <div id="divBuscarDireccion">
                // <input type="submit" name="BuscarDireccion" value="" class="buttonBuscar" id="BuscarDireccion">
            // </div>
        // </form>
    // </div>
		
		
        return $html;
    }
    
   /**
    * Scaleform with scale options
    */
    public static function scaleForm()
    {
        $html = "<div id=\"scaleAreaX\" class=\"TOOLFRAME\">
                <form id=\"scaleform\"  action=\"javascript:PM.Map.zoom2scale($('#scaleinput').val());javascript:PM.Form.scaleMouseOut(true)\">
                    <div id=\"scaleArea2\" class=\"rowdiv\" >
                        <div class=\"celldiv\">" . _p("Scale") . " 1:  </div>
                        <div class=\"celldiv\">
                            <div> <input type=\"text\" id=\"scaleinput\" name=\"scale\" size=\"9\" value=\"\" onkeyup=\"PM.Form.scaleMouseOut()\" onblur=\"PM.Form.scaleMouseOut(true)\" onclick=\"PM.Form.initScaleSelect()\" /></div>
                            <div id=\"scaleSuggest\" onmouseover=\"PM.Form.setScaleMO()\" onmouseout=\"setTimeout('PM.Form.scaleMouseOut()', 1000)\"></div>
                        </div>
                    </div>
                </form>
            </div>
        ";
        return $html;
    }
    
    
   /**
    * Slider for zooming
    */
    public static function zoomSlider()
    {
	//Ajuste tamaño según dim pantalla, quitar recuadro envolvente
        $html = "<div id=\"sliderArea\" class=\"sliderAreaOut\" >
                <div id=\"sliderTool\">
                    <div class=\"slider-top\"><img id=\"sl_imgplus\" src=\"images/zoomplus.gif\" alt=\"\" title=\"" . _p("Zoom in") . "\"  onclick=\"PM.Map.zoompoint(2, '');\"/></div>
                    <div id=\"zslider\"></div>
                    <div class=\"slider-bottom\"><img id=\"sl_imgminus\" src=\"images/zoomminus.gif\" alt=\"\" title=\"" . _p("Zoom out") . "\"  onclick=\"PM.Map.zoompoint(-2, '');\"/></div>
                </div>
            </div>
        ";
        return $html;
    }
    
    
   /**
    * Dialog Container for dynwin
    
    public static function dialogContainer()
    {
        $html = "<div style=\"visibility:hidden\"><img id=\"pmMapRefreshImg\" src=\"images/pixel.gif\" alt=\"\" /></div>
            <div id=\"pmDlgContainer\"   class=\"jqmDialog hide\"></div>
            <div id=\"pmQueryContainer\" class=\"jqmDialog hide\"></div>
        ";
        return $html;
    }*/
    
	public static function ocultarPanel() {
	/*menudown.gif*/
		
		$html = "<div class=\"ocultar-panel\">					
					<a id=\"textoClosePanelLateral\" href=\"javascript:CerrarPanelLateral();\">
					<span id=\"iconClosePanelLateral\" title=\"Ocultar panel\"></span>
					</a>
				</div>
		";
        return $html;
	}
    
   /**
    * Header in ui-north
    */
    public static function pmHeader()
    {
        $pmLogoUrl = array_key_exists('pmLogoUrl', $_SESSION) ? $_SESSION['pmLogoUrl'] : "http://www.motril.es";
        $pmLogoTitle = array_key_exists('pmLogoTitle', $_SESSION) ? $_SESSION['pmLogoTitle'] : "Matoojos";
        $pmLogoSrc = array_key_exists('pmLogoSrc', $_SESSION) ? $_SESSION['pmLogoSrc'] : "images/logos/matojos_logo.png";
        $pmVersion = array_key_exists('version', $_SESSION) ? ", v" . $_SESSION['version'] : "0.0.10";
        /*$pmHeading = array_key_exists('pmHeading', $_SESSION) ? $_SESSION['pmHeading'] : "<a href=\"http://mapserver.gis.umn.edu\" id=\"mshref_1\" title=\"UMN MapServer homepage\" onclick=\"this.target = '_new';\">MapServer</a>&nbsp; 
                            <a href=\"http://www.dmsolutions.ca\" id=\"dmsol_href\" title=\"DM Solutions homepage\" onclick=\"this.target = '_new';\">PHP/MapScript</a>&nbsp; 
                            Framework$pmVersion";*/
		$pmHeading = array_key_exists('pmHeading', $_SESSION) ? $_SESSION['pmHeading'] : "Matojos";
		$pmSubHeading = array_key_exists('pmSubHeading', $_SESSION) ? $_SESSION['pmSubHeading'] : "SIG del área de Agricultura, parques y jardines";
        
		/*
		<a id=\"textoClosePanelLateral\" href=\"javascript:CerrarPanelLateral();\">
<span id=\"iconClosePanelLateral\" title=\"Ocultar panel\"></span>
</a>
menudown.gif*/
        /*$html = "<div class=\"pm-header\">
					<div class=\"HEADING1\">$pmHeading
					
					
					</div>
					<div id=\"img-logo-principal\">
						<a href=\"$pmLogoUrl\" title=\"$pmLogoTitle\" onclick=\"this.target = '_blank';\">
						<img class=\"pm-logo-img\" src=\"$pmLogoSrc\" alt=\"logo\" height=\"60\" width=\"200\" /></a>    
                    </div>
                    
					<div class=\"HEADING2\">$pmHeading</div>
                </div>
        ";*/
		
		$html = "<div class=\"pm-header\">
					
					<div id=\"img-logo-principal\">
						<a href=\"$pmLogoUrl\" title=\"$pmLogoTitle\" onclick=\"this.target = '_blank';\">
						<img class=\"pm-logo-img\" src=\"$pmLogoSrc\" alt=\"logo\" height=\"60\" width=\"200\" /></a>    
                    </div>
					<div id=\"img-logo-secundario\">
						<a href=\"$pmLogoUrl\" title=\"$pmLogoTitle\" onclick=\"this.target = '_blank';\">
						<img class=\"pm-logo-img\" src=\"images/logos/Agricultura.png\" alt=\"logo\" height=\"30\" width=\"100\" /></a>    
                    </div>
                    		<a id=\"textoClosePanelLateral\" href=\"javascript:CerrarPanelLateral();\">
<span id=\"iconClosePanelLateral\" title=\"Ocultar panel\"></span>
</a>
					
                </div>
        ";
        return $html;
    }
    
	/**
	 * Panel lateral - Cabecera
	 */
	public static function PL_Cabecera() {
		// Datos del logotipo principal
		$LPAHref = "#";
		$LPATitle = "Acerca de Matojos";
		$LPAOnclick = "";
		$LPImgSrc = "images/logos/matojos-logo.png";
		$LPImgAlt = "Matojos";
		
		// Datos del logotipo secundario
		$LSAHref = "http://www.motril.es";
		$LSATitle = "Ayuntamiento de Motril";
		$LSAOnclick = "this.target = '_blank';";
		$LSImgSrc = "images/logos/agricultura.png";
		$LSImgAlt = "Ayuntamiento de Motril - Área de Agricultura";
		
		// Datos del botón para ocultar el panel lateral
		$BOPLAHref = "javascript:OcultarPanelLateral();";
		$BOPLATitle = "Ocultar panel";
		$BOPLAOnclick = "this.target = '_self';";
		$BOPLImgSrc = "images/botones/flecha-patras.png";
		$BOPLImgAlt = "Ocultar";
		
		// Código HTML
		$html = "<div id=\"cabecera-panel-lateral\">
					<a id=\"logo-principal\" href=\"$LPAHref\" title=\"$LPATitle\" onclick=\"$LPAOnclick\">
						<img src=\"$LPImgSrc\" alt=\"$LPImgAlt\"/>
					</a>
					<a id=\"ocultar-panel-lateral\" href=\"$BOPLAHref\" title=\"$BOPLATitle\" onclick=\"$BOPLAOnclick\">
						<img src=\"$BOPLImgSrc\" alt=\"$BOPLImgAlt\"/>
					</a>
					<a id=\"logo-secundario\" href=\"$LSAHref\" title=\"$LSATitle\" onclick=\"$LSAOnclick\">
						<img src=\"$LSImgSrc\" alt=\"$LSImgAlt\"/>
					</a>
				</div>";
		
		// Devolver código HTML
		return $html;
	}
	
   /**
    * Footer in ui-south
    */
    public static function pmFooter()
    {
        // $html = "<div class=\"pm-footer\">
                // <div style=\"float:right;\">
                    // <a href=\"http://validator.w3.org/check?uri=referer\"><img
                        // src=\"images/logos/valid-xhtml10-small-blue.png\"
                        // alt=\"XHTML 1.0 Strict\"  /></a>
                // </div>
                // <div style=\"float:right;\"><a href=\"http://mapserver.gis.umn.edu\" id=\"mapserver_href_2\" onclick=\"this.target = '_blank';\">
                    // <img src=\"images/logos/mapserver-small.png\" title=\"UMN MapServer homepage\" alt=\"MapServer\" /></a>
                // </div>
                // <div style=\"float:right;\"><a href=\"http://www.pmapper.net\"  title=\"p.mapper homepage\" onclick=\"this.target = '_blank';\">
                    // <img src=\"images/logos/pmapper.png\" title=\"p.mapper\" alt=\"p.mapper\" /></a></div>
            // </div>
        // ";
		//Servicio de Información Geográfica de parques, jardines y flora del municipio de Motril - Área de Agricultura, Parques y Jardines
		$html = "<div class=\"pm-footer\">
					<div style=\"float:right; position:relative; \">
						<a href=\"http://labellotasoft.co.uk\">
							<img src=\"images/logos/logo_con_nombre.png\" height=\"34px\" width=\"94px\" alt=\"La Bellota Soft Ltd.\"  />
						</a>
					</div>
					<div style=\"float:right; position:relative; bottom:0px;\">
						Matojos 0.0.1©  2014 - Servicio de Información Geográfica de parques, jardines y flora del municipio de Motril
					</div>
				</div>
		";
        return $html;
    }
	
	/**
	 * Panel central - Pie
	 */
	public static function PC_Pie() {
		
		// Datos de la versión actual
		$version = array_key_exists('versionMatojos', $_SESSION) ? $_SESSION['versionMatojos'] : "0.1.4";
		$ano_reventado = date("Y");
		
		// Código HTML
		$html = "<div id=\"pie-panel-central\">
					<p>
						Matojos $version" . "© $ano_reventado - Servicio de Información Geográfica de parques, jardines y flora del municipio de Motril.
					</p>
				</div>";
		
		// Devolver código HTML
		return $html;
	}

	/**
	 * Panel central - Logotipo de LBSL.
	 */
	public static function PC_LogoLBSL() {
		
		// Datos del logotipo
		$AHref = "http://labellotasoft.co.uk";
		$ATitle = "La Bellota Soft Ltd.";
		$AOnclick = "this.target = '_blank';";
		$ImgSrc = "images/logos/logo_con_nombre.png";
		$ImgAlt = "La Bellota Soft";
		
		// Código HTML
		$html = "<div id=\"labellota-logo\">
					<a href=\"$AHref\" title=\"$ATitle\" onclick=\"$AOnclick\">
						<img src=\"$ImgSrc\" alt=\"$ImgAlt\"/>
					</a>
				</div>";
		
		// Devolver código HTML
		return $html;
	}
   /**
    * Coordinates display
    */
    public static function displayCoordinates()
    {
        $html = "<div id=\"showcoords\" class=\"showcoords1\"><div id=\"xcoord\"></div><div id=\"ycoord\" ></div></div>";
        return $html;
    }
    
   /**
    * Mandatory form for handling update events
    */
    public static function addUpdateEventForm()
    {
        $html = "<form id=\"pm_updateEventForm\" action=\"\">
                    <p><input type=\"hidden\" id=\"pm_mapUpdateEvent\" value=\"\" /></p>
                </form>";
        return $html;
    }

}



?>
