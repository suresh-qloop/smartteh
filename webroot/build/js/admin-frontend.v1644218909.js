$(window).load(function(){var toolbar=$("#admin-tools");if(toolbar.length){repositionAdminToolbar(toolbar);$(window).resize(function(){clearTimeout(window.resize_timeout);window.resize_timeout=setTimeout(function(){repositionAdminToolbar(toolbar)},500)})}});function repositionAdminToolbar(toolbar){var item_h=toolbar.data("original-item-height");if(!item_h){item_h=toolbar.find("li").eq(0).height()+1;toolbar.data("original-item-height",item_h)}var font_size=toolbar.data("original-font-size");if(!font_size){font_size=parseInt(toolbar.css("font-size"),10);toolbar.data("original-font-size",font_size)}var window_h=$(window).height(),item_c=toolbar.find("li").length,toolbar_h=item_h*item_c,toolbar_y=Math.floor((window_h-toolbar_h)/2),styles={visibility:"visible"};if(toolbar_y<0){item_h=Math.floor(window_h/item_c);toolbar_h=item_h*item_c;toolbar_y=Math.floor((window_h-toolbar_h)/2);font_size=Math.round(toolbar.data("original-font-size")*(item_h/toolbar.data("original-item-height")));if(font_size<14){font_size=14}}styles["line-height"]=item_h-1+"px";styles["font-size"]=font_size+"px";styles["top"]=toolbar_y+"px";toolbar.css(styles)}