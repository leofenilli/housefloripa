/* Copyright (C) Elartica Team, http://www.gnu.org/licenses/gpl.html GNU/GPL */

!function(e,a){e(function(){e("main.tm-main > .tm-form").append('<div class="tm-form-save"><button type="submit" class="uk-button uk-button-primary js-save-settings">Save changes</button> <span></span></div>');var a=e('input:checkbox[name$="[title]"]');e.each(a,function(){e(this).after(e(this).clone().attr("type","hidden").val(e(this).is(":checked")?"1":"0"))}),a.on("change",function(){e(this).next().val(e(this).is(":checked")?"1":"0")}),e('[data-warp="theme"] .js-save-settings').on("click",function(e){e.preventDefault(),t.save(this)})});var t={save:function(a){var t={},s=e(a);s.attr("disabled",!0).next().attr("class","uk-icon-spinner uk-icon-spin"),parse_str(e(":input","#theme-options").serialize(),t),e.ajax({url:ajaxurl,type:"post",data:{action:"warp_save",config:JSON.stringify(t,null,"	")},success:function(a){var t=!1;try{a=e.parseJSON(a),"success"==a.message&&(t=!0)}catch(n){}t||alert("Save failed!"),setTimeout(function(){s.attr("disabled",!1).next().attr("class","")},300)}})},saveFiles:function(a){var t=e.Deferred(),s=new FormData;return s.append("action","warp_save_files"),s.append("files",new Blob([JSON.stringify(a)],{type:"text/plain"})),e.ajax({url:ajaxurl,type:"POST",data:s,processData:!1,contentType:!1}).always(function(a,s,n){var r=!1;if("error"==s)r=n;else try{a=e.parseJSON(a),"success"!=a.message&&(r=a.message)}catch(i){r="Saving failed!"}t[r?"reject":"resolve"](r)}),t.promise()},data:function(){var a=e.Deferred();return e.ajax({url:ajaxurl,type:"post",data:{action:"warp_get_styles"}}).always(function(t,s,n){var r=!1;if("error"==s)r=n;else try{if(t=e.parseJSON(t),"error"!=t.message)return void a.resolve(t);r=t.message}catch(i){r="Retrieving styles data failed!"}a.reject(r)}),a.promise()}};a.System=t}(jQuery,this);