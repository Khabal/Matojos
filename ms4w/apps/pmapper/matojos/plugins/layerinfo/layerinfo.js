/******************************************************************************
 *
 * Purpose: display infos for layers in pop up
 * Author:  Armin Burger
 *
 ******************************************************************************
 *
 * Copyright (c) 2003-2009 Armin Burger
 *
 * This file is part of p.mapper.
 *
 * p.mapper is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. See the COPYING file.
 *
 * p.mapper is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with p.mapper; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 ******************************************************************************/

$.extend(PM.Custom,
{

    dlgOptions: {width:300, height:200, resizeable:true, newsize:false, container:'pmDlgContainer'},
    
    showGroupInfo: function(groupId) {
        var groupName = groupId.replace(/ligrp_/, '');
        var dlg = PM.Dlg.createDnRDlg(this.dlgOptions, _p('Layer Info'), false);
        $.ajax({
            type: "POST",
            url: PM_PLUGIN_LOCATION + '/layerinfo/x_layerinfo.php',
            data: SID + '&group=' + groupName,
            dataType: "html",
            success: function(response) {
                $('#pmDlgContainer_MSG').html(response);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (window.console) console.log(errorThrown);
            }
        });
    }

});
