<?php

require_once("../../incphp/pmsession.php");
require_once("../../incphp/group.php");
require_once("../../incphp/globals.php");


header("Content-Type: text/javascript; charset=$defCharset");

?>


//<script type="text/javascript">

/*************************************************************
 *                                                           *
 *          JavaScript configuration settings                *
 *                                                           *
 *************************************************************/


/**
 * Set to true if cursor shall change according to active tool (default: true)
 */
PM.useCustomCursor = true;


/**
 * Define scale selection list: 
 * ==> adapt to scale range of your data
 * ==> set empty array for disabling function 
 * values can be numbers or numbers containing 1000-separators [. , ' blank]
 */
PM.scaleSelectList = []; 
//PM.scaleSelectList = [5000, 10000, 25000, 50000, 100000, 250000, 500000, 1000000, 2500000]; 
//PM.scaleSelectList = [100000, 250000, 500000, 1000000, 2500000, 5000000, 10000000, 25000000]; 
//PM.scaleSelectList = ["100.000", "250.000", "500.000", "1.000.000", "2.500.000", "5.000.000", "10.000.000", "25.000.000"];
//PM.scaleSelectList = ["100,000", "250,000", "500,000", "1,000,000", "2,500,000", "5,000,000", "10,000,000", "25,000,000"];
//PM.scaleSelectList = ["100'000", "250'000", "500'000", "1'000'000", "2'500'000", "5'000'000", "10'000'000", "25'000'000"];
//PM.scaleSelectList = ["100 000", "250 000", "500 000", "1 000 000", "2 500 000", "5 000 000", "10 000 000", "25 000 000"];


/**
 * Enable pan mode if right mouse button is pressed
 * independent of selected tool (default: true)
 */
PM.enableRightMousePan = true;


/**
 * Define query result layout: tree or table (default: table)
 */
//PM.queryResultLayout = 'tree';
PM.queryResultLayout = 'table';

/**
 * Define tree style for queryResultLayout = 'tree'
 * css: "red", "black", "gray"; default: none; styles defined in /templates/treeview.css
 * treeview:
 *   @option String|Number speed Speed of animation, see animate() for details. Default: none, no animation
 *   @option Boolean collapsed Start with all branches collapsed. Default: true
 *   @option Boolean unique Set to allow only one branch on one level to be open
 *         (closing siblings which opening). Default: true
 */
//PM.queryTreeStyle = {css: "red", treeview: {collapsed: true, unique: true}};
PM.queryTreeStyle = {treeview: {collapsed: true, unique: true, persist:false}};


/**
 * Close categories tree in array on startup
 * same as setting category in config.xml as 
 *   <category name="cat_nature" closed="true">
 * (default: all categories open)
 */
//PM.categoriesClosed = ['cat_nature'];


/**
 * Define style of treeview for TOC 
 * default: {collapsed:true, persist:false} 
 */
PM.tocTreeviewStyle = {collapsed:true, persist:false, animated:'fast'};


/**
 * Define if zoom slider is vertical (default: true)
 */
PM.zsliderVertical = true;


/**
 * Decide if auto-identify shall show pop-up element at mouse pointer (default: false)
 */
PM.autoIdentifyFollowMouse = false;


/**
 * Define if internal (default) cursors should be used for mouse cursors (default: false)
 */
PM.useInternalCursors = false;


/**
 * Define if select a SUGGEST row will directly launch the search (default: true)
 */
PM.suggestLaunchSearch = true;


/**
 * Units for measurement (distance, area)
 */
//var pmMeasureUnits = {distance:" [m]", area:" [m&sup2;]", factor:1}; 
//PM.measureUnits = {distance:" [km]", area:" [km&sup2;]", factor:1000};
PM.measureUnits = {distance:" [m]", area:" [m&sup2;]", factor:1};

/**
 * Lines and polygon styles for measurement
 */
PM.measureObjects = {line: {color:"#FF0000", width:2}}; 

/**
 * Invert wheel zoom action to follow Google behaviour (default: false)
 */
PM.ZoomBox.wheelZoomGoogleStyle = true;

/**
 * Sample for reprojecting ETRS89 LAEA dislay coordinates to lonlat WGS84 
 * requires loading of "proj4js" plugin in config_default.xml
 */
/*
Proj4js.defs["EPSG:3035"]="+proj=laea +lat_0=52.00000000 +lon_0=10.0000000 +x_0=4321000 +y_0=3210000 +ellps=GRS80 +units=m +no_defs ";
PM.ZoomBox.coordsDisplayReproject = true;
PM.ZoomBox.coordsDisplaySrcPrj = "EPSG:3035";
PM.ZoomBox.coordsDisplayDstPrj = "EPSG:4326";
PM.ZoomBox.coordsDisplayRfactor = 4;
*/

//Proj4js.defs["EPSG:32632"]="+proj=utm +zone=32 +ellps=WGS84 +datum=WGS84 +units=m +no_defs ";
Proj4js.defs["EPSG:32632"]="+proj=utm +zone=30S +ellps=WGS84 +datum=WGS84 +units=m +no_defs ";
PM.ZoomBox.coordsDisplayReproject = true;
PM.ZoomBox.coordsDisplaySrcPrj = "EPSG:32632";
PM.ZoomBox.coordsDisplayDstPrj = "EPSG:4326";
PM.ZoomBox.coordsDisplayRfactor = 4;

/**
 * Redefinición de la función por defecto para mostrar las coordenadas en el cuadro de coordenadas
 */
PM.ZoomBox.displayCoordinates = function() {
	var mpoint = this.getGeoCoords(this.moveX, this.moveY);
	
	// Reproject coords if defined
	if(this.coordsDisplayReproject) {
		mpoint = this.transformCoordinates(this.coordsDisplaySrcPrj, this.coordsDisplayDstPrj, mpoint);
	}
	
	// Round values (function 'roundN()' in 'measure.js')
	var px = isNaN(mpoint.x) ? '' : mpoint.x.roundTo(this.coordsDisplayRfactor);
	var py = isNaN(mpoint.y) ? '' : mpoint.y.roundTo(this.coordsDisplayRfactor);
	
	// Descomponer las coordenadas en grados, minutos y segundos
	var dirx, gradox, minutox, segundox, diry, gradoy, minutoy, segundoy;
	
	if(px > 0) {
		dirx = " E";
	}
	else {
		dirx = " O";
		px *= -1;
	}
	
	if(py > 0) {
		diry = " N";
	}
	else {
		diry = " S";
		py *= -1;
	}
	
	gradox = Math.floor(px);
	minutox = (px % 1) * 60;
	segundox = Math.floor((minutox % 1) * 60);
	minutox = Math.floor(minutox);
	
	gradoy = Math.floor(py);
	minutoy = (py % 1) * 60;
	segundoy = Math.floor((minutoy % 1) * 60);
	minutoy = Math.floor(minutoy);
	
	// Display in DIV  
	PM.ZoomBox.yCoordCont.html(gradox + "º " + minutox + "' " + segundox + "''" + dirx);
	PM.ZoomBox.xCoordCont.html(gradoy + "º " + minutoy + "' " + segundoy + "''" + diry);
};



/**
 * Definitions of context menus
 * parameters for styles are: menuStyle, itemStyle, itemHoverStyle
 * for details see http://www.trendskitchens.co.nz/jquery/contextmenu/
 */
PM.contextMenuList = [     
    {bindto: 'li.tocgrp',        
     menuid: 'cmenu_tocgroup',
     menulist: [   
        {id:'info',   imgsrc:'info-b.png', text:'Layer Info',  run:'PM.Custom.showGroupInfo'},
        {id:'open',   imgsrc:'transparency-b.png', text:'Transparency',   run:'PM.Plugin.Transparency.cmOpenTranspDlg'},
        {id:'email',  imgsrc:'zoomtolayer-b.png',  text:'Zoom To Layer',  run:'PM.Map.zoom2group' }], 
     styles: {menuStyle: {width:'auto'}}
    },
    {bindto: 'li.toccat',
     menuid: 'cmenu_toccat',
     menulist: [
        {id:'layerson',  imgsrc:'layerson-b.png', text:'Layers On',  run:'PM.Toc.catLayersSwitchOn'},
        {id:'layersoff', imgsrc:'layersoff-b.png', text:'Layers Off',  run:'PM.Toc.catLayersSwitchOff'},
        {id:'info',   imgsrc:'info-b.png', text:'Info',  run:'PM.Custom.showCategoryInfo'} ], 
     styles: {menuStyle: {width:'auto'}}
    }
];


/**
 * Layout of scalebar (from plugin)
 */
PM.scaleBarOptions = {divisions:2, subdivisions:2, resolution:96, minWidth:120, maxWidth:160, abbreviateLabel:true};


/**
 * Toolbar elements
 * toolbarid: Id to use for toolbar <div>, CSS definition via 'layout.css'
 * options: orientation: "v"=vertical, "h"=horizontal
 *          css: additional CSS styles, overwriting the ones in 'layout.css'
 *          theme: image directories under /images/buttons/
 * buttons: stateless buttons: add "run:'scriptToExecuteOnClick'"
 *          space/separator: need to be defined with increasing number at the end, dimension: in px
 */
PM.buttonsDefault = {
    toolbarid:'toolBar',
    options: {orientation:'v',
              css:{height:'440px'},
              theme:'default',
              imagetype:'gif'
             }, 
    buttons: [
        {tool:'space1',        dimension: 15},
        {tool:'home',          name:'Zoom To Full Extent', run:'PM.Map.zoomfullext'},
        {tool:'back',          name:'Back', run:'PM.Map.goback'},
        {tool:'fwd',           name:'Forward', run:'PM.Map.gofwd'},
        {tool:'zoomselected',  name:'Zoom To Selected', run:'PM.Map.zoom2selected'},
        {tool:'separator1',    dimension:1},
        {tool:'zoomin',        name:'Zoom in'},
        {tool:'zoomout',       name:'Zoom out'},
        {tool:'pan',           name:'Pan'},
        {tool:'separator2',    dimension:1},
        {tool:'identify',      name:'Identify'},
        {tool:'select',        name:'Select'},
        {tool:'auto_identify', name:'Auto Identify'},
        {tool:'separator3',    dimension: 1},
        {tool:'measure',       name:'Measure'},
        //{tool:'coordinates',       name:'Coordinates'},
        {tool:'separator4',    dimension: 1},
        {tool:'transparency',  name:'Transparency', run:'PM.Plugin.Transparency.openTransparencyDlg'},
        {tool:'reload',        name:'Refresh Map', run:'PM.Map.clearInfo'}
    ]
};

// Estilo y elementos de la barra de herramientas
PM.botonesTuneados = {
	toolbarid:'toolBar',
	options: {
		orientation:'v',
		css:{height:'590px'},
		theme:'tuneado',
		imagetype:'png'
	},
	buttons: [
		{tool:'space1', dimension:5},
		{tool:'home', name:'Zoom To Full Extent', run:'PM.Map.zoomfullext'},
		{tool:'back', name:'Back', run:'PM.Map.goback'},
		{tool:'fwd', name:'Forward', run:'PM.Map.gofwd'},
		{tool:'zoomselected', name:'Zoom To Selected', run:'PM.Map.zoom2selected'},
		{tool:'separator1', dimension:1},
		{tool:'zoomin', name:'Zoom in'},
		{tool:'zoomout', name:'Zoom out'},
		{tool:'pan', name:'Pan'},
		{tool:'separator2', dimension:1},
		{tool:'identify', name:'Identify'},
		{tool:'select', name:'Select'},
		{tool:'auto_identify', name:'Auto Identify'},
		{tool:'separator3', dimension:1},
		{tool:'measure', name:'Measure'},
		{tool:'scale', name:'Scale', run:'PM.Dlg.abrirFormularioEscala'},
		{tool:'separator4', dimension:1},
		{tool:'transparency', name:'Transparency', run:'PM.Plugin.Transparency.openTransparencyDlg'},
		{tool:'reload', name:'Refresh Map', run:'PM.Map.clearInfo'},
		{tool:'separator5', dimension:1},
		{tool:'link', name:'Link', run:'PM.UI.showMapLink'},
		{tool:'print', name:'Print', run:'PM.Dlg.openPrint'},
		{tool:'download', name:'Download', run:'PM.Dlg.openDownload'},
		{tool:'help', name:'Help', run:'PM.Dlg.openHelp'}
	]
};

// Establece si por defecto se muestra la barra de herramientas o no
PM.barraHerramientasOculta = true;

/**
 * Tool link elements
 */
PM.linksDefault = {
    containerid:'toolLinkContainer',
    links: [
        {linkid:'link', name:'Link', run:'PM.UI.showMapLink', imgsrc:'link-w.png'},
        {linkid:'print', name:'Print', run:'PM.Dlg.openPrint', imgsrc:'print-w.png'},
        {linkid:'download', name:'Download', run:'PM.Dlg.openDownload', imgsrc:'download-w.png'},
        {linkid:'help', name:'Help', run:'PM.Dlg.openHelp', imgsrc:'help-w.png'},
        {linkid:'home', name:'Home', run:'http://www.pmapper.net', target:'_new', imgsrc:'home-w.png'}
        //{linkid:'layers', name:'Layers', run:'PM.Plugin.Layerselect.openDlg', imgsrc:'layers-bw.png'}
        
    ]
};


/**
 * Tabs used for swapping between TOC and legend (legStyle=swap)
 */

PM.tocTabs = {
    tabid: 'pmTocTabulators',
    options: {
        mainClass: 'pm-tabs'
    },
    tabs: [
        {tabid:'layers', name:'Layers', run:'PM.Toc.swapToLayerView', imgsrc:null, active:true},
        {tabid:'legend', name:'Legend', run:'PM.Toc.swapToLegendView', imgsrc:null}
    ]
};

/*
******************
*/

function createZSlider(sliderElemId) {
    if (_$(sliderElemId)) {
        myslider = new slider(
        sliderElemId,	// id of DIV where slider is inserted
        194,			//height of track
        6,				//width of track
        '666666',		//colour of track
        0,				//thickness of track border
        '#DCDCDC',		//colour of track border
        2,				//thickness of runner (in the middle of the track)
        '#666666',		//colour of runner
        16,				//height of button
        16,				//width of button
        '#000000',		//colour of button
        0,				//thickness of button border (shaded to give 3D effect)
        '<img src="images/botones/subir-bajar.png" style="display:block; margin:auto; cursor:url(/matojos/images/punteros/mover.cur), auto;" alt="Indicador" />', //text of button (if any)
        //'', //text of button (if any)
        false,			//direction of travel (true = horizontal, false = vertical)
        'sliderMove',	//the name of the function to execute as the slider moves
        'sliderStop',	//the name of the function to execute when the slider stops
        true			//the functions must have already been defined (or use null for none)
        );
    }
}

$.extend(PM.Dlg, {
	// Parámetro del diálogo del formulario para cambiar la escala del mapa
	FormularioEscalaDlgParam:{width:160, height:90, left:250, top:250, resizeable:false, newsize:true, container:'pmDlgContainer', name:'FormularioEscala'},
	
	/**
	 * Abrir diálogo para cambiar la escala
	 */
	abrirFormularioEscala:function() {
		this.createDnRDlg(this.FormularioEscalaDlgParam, _p('Escala'), 'formescaladlg.phtml?' + SID);
	}
	
});

    /** 
     * set the cursor to standard internal cursors
     * or special *.cur url (IE6+ only)
     */
PM.setCursor = function(rmc, ctype) {
	if(!rmc) {
		if(PM.Map) {
			var toolType = PM.Map.tool;
		}
		else {
			var toolType = 'zoomin';
		}
	}
	else {
		toolType = 'pan';
	}
	
	// Obtener definiciones desde js_config.php 
	var iC = PM.useInternalCursors;
	
	// En navegadores 'safari' y 'chrome' no es recomendable usar cursores personalizados
	if($.browser.webkit) {
		iC = false;
	}
	
	var rootPath = this.getRootPath();
	
	// Ajuste a la ruta porque no funciona bien la mierda esta
	rootPath += "matojos/";
	
	var usedCursor = (iC) ? toolType : 'url("' + rootPath + 'images/punteros/puntero-defecto.cur"), default';
	
	// Adecuar puntero del ratón en base a la herramienta seleccionada
	switch(toolType) {
		case "zoomin":
			var usedCursor = (iC) ? 'zoom-in' : 'url("' + rootPath + 'images/punteros/acercar.cur"), zoom-in';
			break;
		
		case "zoomout":
			var usedCursor = (iC) ? 'zoom-out' : 'url(' + rootPath + 'images/punteros/alejar.cur), zoom-out';
			break;
		
		case "identify":
			var usedCursor = (iC) ? 'help' : 'url(' + rootPath + 'images/punteros/identificar.cur), help';
			break;
		
		case "auto_identify":
			var usedCursor = (iC) ? 'help' : 'url(' + rootPath + 'images/punteros/examinar.cur), help';
			break;
		
		case "pan":
			var usedCursor = (iC) ? 'move' : 'url(' + rootPath + 'images/punteros/mover.cur), move';
			break;
		
		case "select":
			var usedCursor = (iC) ? 'crosshair' : 'url(' + rootPath + 'images/punteros/cruz.cur), crosshair';
			break;
		
		case "measure":
			var usedCursor = (iC) ? 'copy' : 'url(' + rootPath + 'images/punteros/medir.cur), copy';
			break;
		
		case "digitize":
			var usedCursor =  'crosshair';
			break;
		
		default:
			var usedCursor = (iC) ? 'default' : 'url(' + rootPath + 'images/punteros/puntero-defecto.cur), default';
	}
	
	if(ctype) {
		usedCursor = ctype;
	}
	
	$('#mapimgLayer').css({'cursor': usedCursor});
};

//</script>
